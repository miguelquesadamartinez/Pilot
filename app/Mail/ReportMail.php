<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $mailInfo, private $file, private $name)
    {
        $this->mailInfo = $mailInfo;
        $this->file = $file;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Report Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.report',
            with: ['mailInfo' => $this->mailInfo],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    */
    /*
     public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->file)
                        ->as('report.csv')
                        ->withMime('application/csv'),

        ];
    }
 */
    public function build()
    {
        return $this->attach(
                        $this->file,
                        [
                            'as' =>  $this->name,
                            'mime' =>  'application/csv',
                        ]
                    );
    }
}
