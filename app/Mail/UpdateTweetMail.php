<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateTweetMail extends Mailable
{
  use Queueable, SerializesModels;

  // ユーザ情報をいれるための変数を用意しておく
  protected $user;
  protected $tweet;

  /**
   * Create a new message instance.
   */
  // $userに入力されたユーザ情報が入ってくる
  public function __construct($user, $tweet)
  {
    // 用意した変数に受け取ったユーザ情報をいれる
    $this->user = $user;
    $this->tweet = $tweet;
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Update Tweet Mail',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'email.tweets.update',
      with: [
        'user' => $this->user,
        'tweet' => $this->tweet,
      ],
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return [];
  }
}
