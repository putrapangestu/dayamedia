<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 30;

    public function __construct(
        public string $number,
        public string $message
    ) {}

    public function handle(): void
    {
        Log::info('start job whatsapp');

        $baseUrl = config('whatsapp.base_url');
        $apiKey = config('whatsapp.api_key');
        $sender = config('whatsapp.sender');

        if (! $apiKey || ! $sender) {
            Log::warning('WhatsApp config tidak lengkap', [
                'api_key_exists' => ! is_null($apiKey),
                'sender' => $sender,
                'number' => $this->number,
            ]);
            return;
        }

        Log::info('start setup');

        $gapKey = "wa:last-sent:{$this->number}";
        $last = Cache::get($gapKey);
        $minGap = (int) env('WHATSAPP_MIN_GAP_SECONDS', 5);
        if ($last && now()->getTimestamp() - (int) $last < $minGap) {
            $sleep = $minGap - (now()->getTimestamp() - (int) $last);
            if ($sleep > 0) {
                sleep($sleep);
            }
        }

        $query = [
            'api_key' => $apiKey,
            'sender' => $sender,
            'number' => $this->number,
            'message' => $this->message,
        ];

        Log::info('end setup cache & query');

        $client = new Client([
            'timeout' => 10,
            'http_errors' => false,
        ]);

        try {
            $response = $client->request('GET', $baseUrl, ['query' => $query]);
            $body = (string) $response->getBody();
            if ($response->getStatusCode() === 200) {
                Log::info('WhatsApp message sent', [
                    'phone' => $this->number,
                    'status_code' => $response->getStatusCode(),
                    'response' => substr($body, 0, 500),
                ]);
            } else {
                Log::error('WhatsApp send failed', [
                    'phone' => $this->number,
                    'status_code' => $response->getStatusCode(),
                    'response' => substr($body, 0, 500),
                ]);
            }
        } catch (RequestException $e) {
            Log::error('WhatsApp send exception', [
                'phone' => $this->number,
                'error' => $e->getMessage(),
            ]);
        } finally {
            Cache::put($gapKey, now()->getTimestamp(), $minGap);
        }
    }
}
