<?php

namespace App\Jobs;

use App\Mail\EmailVerification;
use App\Models\TempEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessSendEmailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tempEmail;

    /**
     * Create a new job instance.
     *
     * @param $tempEmail
     */
    public function __construct(TempEmail $tempEmail)
    {
        $this->tempEmail = $tempEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->tempEmail->new_email)->send(new EmailVerification($this->tempEmail->token));
    }
}
