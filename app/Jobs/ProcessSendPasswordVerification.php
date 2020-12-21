<?php

namespace App\Jobs;

use App\Mail\PasswordVerification;
use App\Models\TempPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessSendPasswordVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tempPassword;

    /**
     * Create a new job instance.
     *
     * @param TempPassword $tempPassword
     */
    public function __construct(TempPassword $tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->tempPassword->user->email)->send(new PasswordVerification($this->tempPassword->token));
    }
}
