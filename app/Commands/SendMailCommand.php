<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class SendMailCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'send {filename : body of the mail in HTML}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Send an email.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        if (! file_exists($filename)) {
            $this->error('File not found.');
            exit;
        }
        $mail = file_get_contents($filename);

        \Mail::send([], [], function ($message) use ($mail) {
            $message->to('test@test.com')->subject('Test Message')->setBody($mail, 'text/html');
        });

        $this->notify('Mail sent!', 'Your email was sent to Mailtrap');
    }
}
