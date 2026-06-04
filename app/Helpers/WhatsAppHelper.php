<?php

use App\Jobs\SendWhatsAppMessage;
use App\Models\WhatsAppTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

if (! function_exists('whatsapp_sanitize_number')) {
    function whatsapp_sanitize_number(?string $number): ?string
    {
        Log::info('start number : '.$number);
        if (! $number) {
            return null;
        }
        $digits = preg_replace('/\D+/', '', $number);
        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }
        if (! str_starts_with($digits, '62')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }
}

if (! function_exists('whatsapp_send')) {
    function whatsapp_send(?string $to, string $message, ?int $delaySeconds = null): void
    {
        Log::info('Send whatsapp start', [
            'to' => $to,
            'message' => $message,
        ]);

        $number = whatsapp_sanitize_number($to);
        if (! $number) {
            return;
        }

        $delay = $delaySeconds ?? (int) env('WHATSAPP_DISPATCH_DELAY', 3);

        $lastKey = "wa:last-dispatch:{$number}";
        $lastAt = Cache::get($lastKey);
        $now = now()->getTimestamp();
        $minGap = (int) env('WHATSAPP_MIN_GAP_SECONDS', 5);
        $extraDelay = 0;
        if ($lastAt && ($lastAt + $minGap) > $now) {
            $extraDelay = ($lastAt + $minGap) - $now;
        }
        Cache::put($lastKey, $now + max($delay, $minGap), $minGap);

        $queueDriver = config('queue.default', env('QUEUE_CONNECTION', 'sync'));
        if ($queueDriver === 'sync') {
            sleep($delay + $extraDelay);
            SendWhatsAppMessage::dispatchSync($number, $message);
        } else {
            SendWhatsAppMessage::dispatch($number, $message)
                ->delay(now()->addSeconds($delay + $extraDelay));
        }
    }
}

if (! function_exists('whatsapp_send_template')) {
    function whatsapp_send_template(string $templateKey, ?string $to, array $variables = [], ?int $delaySeconds = null): void
    {
        $tpl = WhatsAppTemplate::getByKey($templateKey);
        $content = $tpl ? $tpl->process($variables) : Arr::get($variables, 'fallback', '');
        if (! $content) {
            return;
        }
        whatsapp_send($to, $content, $delaySeconds);
    }
}

if (! function_exists('whatsapp_admin_notify')) {
    function whatsapp_admin_notify(string $message, ?int $delaySeconds = null): void
    {
        $admins = getSetting('admin_whatsapp')
            ?: getSetting('payment_confirmation_whatsapp')
            ?: env('WHATSAPP_ADMIN_NUMBER');
        if (! $admins) {
            return;
        }
        $numbers = collect(explode(',', $admins))
            ->map(fn ($n) => trim($n))
            ->filter();
        foreach ($numbers as $n) {
            whatsapp_send($n, $message, $delaySeconds);
        }
    }
}

if (! function_exists('email_send')) {
    function email_send(?string $toEmail, string $subject, string $content): void
    {
        if (! $toEmail) {
            return;
        }
        try {
            Mail::raw($content, function ($m) use ($toEmail, $subject) {
                $m->to($toEmail)->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $toEmail,
                'subject' => $subject,
                'content' => $content,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

if (! function_exists('email_admin_notify')) {
    function email_admin_notify(string $subject, string $content): void
    {
        $admins = getSetting('admin_email', env('ADMIN_EMAILS'));
        if (! $admins) {
            return;
        }
        collect(explode(',', $admins))
            ->map(fn ($e) => trim($e))
            ->filter()
            ->each(function ($email) use ($subject, $content) {
                email_send($email, $subject, $content);
            });
    }
}
