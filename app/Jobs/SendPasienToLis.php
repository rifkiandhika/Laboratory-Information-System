<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPasienToLis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $response = Http::withToken(env('LIS_API_TOKEN'))
                ->timeout(10)
                ->post(env('LIS_API_URL') . '/pasien/sync', $this->payload);

            if ($response->successful()) {
                Log::info("Pasien {$this->payload['no_lab']} terkirim ke LIS");
            } else {
                Log::warning("Gagal kirim pasien ke LIS", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $this->release(60); // retry 60 detik
            }
        } catch (\Exception $e) {
            Log::error("Error kirim pasien ke LIS: " . $e->getMessage());
            $this->release(120); // retry 2 menit
        }
    }
}
