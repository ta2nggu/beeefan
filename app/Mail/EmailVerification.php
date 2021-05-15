<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $fc_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$fc_id)
    {
        $this->user = $user;
        $this->fc_id = $fc_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【Beee Fan!】仮登録完了のお知らせ')
            ->view('vendor.notifications.addAccount')
            ->with(['user' => $this->user,'fc_id' => $this->fc_id]);
    }
}
