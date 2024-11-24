<?php

namespace App\Jobs;

use App\Actions\Emergency\SendOnewaySMS;
use App\Actions\Emergency\SendSemaphoreSMS;
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
            // Send with TextBelt
            // $this->sendWithTextBelt();

            // Send with OnewaySMS
            // $this->sendWithOnewaySMS();

            // Send with Semaphore
            $this->sendWithSemaphore();
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send the SMS using TextBelt
     *
     * @return array
     * @throws Exception
     */
    private function sendWithTextBelt(): array
    {
        $sendSMS = new SendSMS();
        $response = $sendSMS->execute($this->phoneNumber, $this->message);

        Log::info('SMS Sent', $response);

        return $response;
    }

    /**
     * Send the SMS using Semaphore
     *
     * @throws Exception
     */
    private function sendWithSemaphore(): array
    {
        $sendSMS = new SendSemaphoreSMS();
        $response = $sendSMS->execute($this->phoneNumber, $this->message);

        Log::info('SMS Sent', $response);

        return $response;
    }

    private function sendWithOnewaySMS(): void
    {
        $sendSMS = new SendOnewaySMS();
        $response = $sendSMS->execute($this->phoneNumber, $this->message);

        $response_code = $response->json();

        if ($response_code > 0) {
            Log::info('SMS sent successfully to ' . $this->phoneNumber, [
                'response' => $response_code,
            ]);
        } else {
            switch ($response_code) {
                case -100:
                    Log::error($response_code . ' - Failed to send SMS: Credentials are incorrect');
                    break;
                case -200:
                    Log::error($response_code . 'Failed to send SMS: Sender ID is incorrect');
                    break;
                case -300:
                    Log::error($response_code . 'Failed to send SMS: Invalid phone number');
                    break;
                case -400:
                    Log::error($response_code . 'Failed to send SMS: Language type is incorrect');
                    break;
                case -500:
                    Log::error($response_code . 'Failed to send SMS: Invalid characters in message');
                    break;
                case -600:
                    Log::error($response_code . 'Failed to send SMS: Insufficient balance');
                    break;
                default:
                    Log::error($response_code . 'Failed to send SMS: Unknown error');
            }
        }
    }
}
