<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendHasilToLis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;

    /**
     * Create a new job instance.
     */
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
                ->timeout(15)
                ->post(env('LIS_API_URL') . '/hasil/sync', $this->payload);

            if ($response->successful()) {
                Log::info("✅ Hasil untuk pasien {$this->payload['pasien']['no_lab']} terkirim ke LIS");
            } else {
                Log::warning("⚠️ Gagal kirim hasil ke LIS", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $this->release(60); // coba ulang setelah 1 menit
            }
        } catch (\Exception $e) {
            Log::error("❌ Error kirim hasil ke LIS: " . $e->getMessage());
            $this->release(120); // coba ulang setelah 2 menit
        }
    }
}
