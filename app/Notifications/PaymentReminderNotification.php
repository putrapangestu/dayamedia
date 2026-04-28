<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $expiryHours = (int) Setting::get('expired_time', 24);
        $expiryTime = $this->transaction->created_at->addHours($expiryHours);
        $timeRemaining = now()->diffInHours($expiryTime);

        return (new MailMessage)
            ->subject('Pengingat Pembayaran - '.$this->transaction->transaction_code)
            ->greeting('Halo '.$notifiable->full_name.',')
            ->line('Ini adalah pengingat pembayaran untuk transaksi Anda.')
            ->line('Kode Transaksi: '.$this->transaction->transaction_code)
            ->line('Total Pembayaran: Rp. '.number_format($this->transaction->total_amount, 0, ',', '.'))
            ->line('Sisa Waktu Pembayaran: '.$timeRemaining.' jam')
            ->action('Lihat Detail Transaksi', url('/checkout/'.$this->transaction->transaction_code.'/success'))
            ->line('Silakan selesaikan pembayaran Anda sebelum waktu habis.')
            ->line('Terima kasih atas kepercayaan Anda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $expiryHours = (int) Setting::get('expired_time', 24);
        $expiryTime = $this->transaction->created_at->addHours($expiryHours);
        $timeRemaining = now()->diffInHours($expiryTime);

        return [
            'transaction_id' => $this->transaction->id,
            'transaction_code' => $this->transaction->transaction_code,
            'total_amount' => $this->transaction->total_amount,
            'time_remaining' => $timeRemaining,
            'message' => 'Pengingat pembayaran transaksi '.$this->transaction->transaction_code,
        ];
    }
}
