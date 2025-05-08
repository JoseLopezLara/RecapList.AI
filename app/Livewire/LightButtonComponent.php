<?php

namespace App\Livewire;

use App\Models\LightLog;
use Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LightButtonComponent extends Component
{
    public bool $isActive = false;

    #[Reactive]
    public function toggle()
    {
        $this->isActive = !$this->isActive;
        Log::info('Light button state changed:', ['state' => $this->isActive]);

        // LightLog::create([
        //     'status' => $this->isActive
        // ]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://192.168.0.102:8000/status', [
            'status' => $this->isActive
        ]);

        if (!$response->successful()) {
            Log::error('Failed to update light status', [
            'status_code' => $response->status(),
            'response' => $response->body()
            ]);
        }else{
            Log::info('Light status updated successfully', [
            'status_code' => $response->status(),
            'response' => $response->body()
            ]);

            LightLog::create([
                'status' => $this->isActive
            ]);
        }
    }

    public function render()
    {
        return view('livewire.light-button-component');
    }
}
