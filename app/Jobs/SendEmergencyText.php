<?php

namespace App\Jobs;

use App\Actions\Emergency\SendSMS;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendEmergencyText implements ShouldQueue
{
    use Batchable, Queueable;

    private string $phoneNumber;
    private string $message;

    /**
     * Create a new job instance.
     */
    public function __construct(string $phoneNumber, string $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            Log::info('SMS Batch Cancelled');

            return;
        }

        // Send the SMS
        Log::info('Sending SMS to ' . $this->phoneNumber);

        try {
            $sendSMS = new SendSMS();
            $response = $sendSMS->execute($this->phoneNumber, $this->message);

            Log::info('SMS Sent', $response);
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
