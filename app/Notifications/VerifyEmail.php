<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

//21.03.30 김태영, verificationUrl 에서 Carbon, URL 사용
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('admin@example.com', config('app.name'))
            ->subject('【Beee Fan!】メールアドレス認証のお知らせ')
            ->greeting('この度は、Beee Fan!をご利用頂きまして誠にありがとうございます。')
            ->line("ご本人様確認のため、下記URLへ「60分以内」にアクセスし\nメールアドレスの認証を行ってください。")
    //                    ->action('인증하기!', url('email/verify/{id}/{hash}'))
            ->action('認証する', $this->verificationUrl($notifiable))
            ->line("※当メールに心当たりの無い場合は、誠に恐れ入りますが\n破棄して頂けますよう、よろしくお願い致します。");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),//라라벨 6 부터는 get 파라미터로 hash도 받아야함
            ],
        );
    }
}
