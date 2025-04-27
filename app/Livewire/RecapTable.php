<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Recap;
use App\Enums\RecapStatus;

class RecapTable extends Component
{
    public $currentDate;
    public $columns = [];

    public function mount()
    {
        $this->currentDate = Carbon::now()->toDateString();
        $this->loadRecaps();
    }

    protected function loadRecaps()
    {
        // Obtener todos los recaps de la base de datos
        $recaps = Recap::all();

        // Inicializar las columnas
        $this->columns = [
            [
                'id' => 1,
                'title' => 'To Do',
                'cards' => []
            ],
            [
                'id' => 2,
                'title' => 'In Progress',
                'cards' => []
            ],
            [
                'id' => 3,
                'title' => 'Completed',
                'cards' => []
            ]
        ];

        // Distribuir los recaps en las columnas según su estado
        foreach ($recaps as $index => $recap) {
            $cardData = [
                'id' => $recap->id,
                'title' => $recap->title,
                'content' => $recap->content,
                'date' => $recap->date->format('d M, H:i'),
                'status' => $recap->status->value
            ];

            // Colocar en la columna correcta según el estado
            if ($recap->status->value === 'TO') {
                $this->columns[0]['cards'][] = $cardData;
            } elseif ($recap->status->value === 'PROCESS') {
                $this->columns[1]['cards'][] = $cardData;
            } elseif ($recap->status->value === 'DO') {
                $this->columns[2]['cards'][] = $cardData;
            }
        }
    }

    public function changeStatus($cardId, $newStatus)
    {
        // Actualizar el estado en la base de datos
        $recap = Recap::find($cardId);
        if ($recap) {
            $recap->status = $newStatus;
            $recap->save();
            return true;
        }
        return false;
    }

    public function moveCard($sourceColumnId, $targetColumnId, $cardId)
    {
        // Find source column index
        $sourceColumnIndex = collect($this->columns)->search(function($column) use ($sourceColumnId) {
            return $column['id'] == $sourceColumnId;
        });

        if ($sourceColumnIndex === false) return;

        // Find card index in source column
        $cardIndex = collect($this->columns[$sourceColumnIndex]['cards'])->search(function($card) use ($cardId) {
            return $card['id'] == $cardId;
        });

        if ($cardIndex === false) return;

        // Get the card
        $card = $this->columns[$sourceColumnIndex]['cards'][$cardIndex];

        // Determinar el nuevo estado basado en la columna de destino
        $newStatus = 'TO';
        if ($targetColumnId == 1) {
            $newStatus = 'TO';
        } elseif ($targetColumnId == 2) {
            $newStatus = 'PROCESS';
        } elseif ($targetColumnId == 3) {
            $newStatus = 'DO';
        }

        // Cambiar el estado usando la nueva función
        $this->changeStatus($cardId, $newStatus);

        // Actualizar el estado en la tarjeta antes de moverla
        $card['status'] = $newStatus;

        // Remove from source column
        array_splice($this->columns[$sourceColumnIndex]['cards'], $cardIndex, 1);

        // Find target column index
        $targetColumnIndex = collect($this->columns)->search(function($column) use ($targetColumnId) {
            return $column['id'] == $targetColumnId;
        });

        if ($targetColumnIndex === false) return;

        // Add to target column
        $this->columns[$targetColumnIndex]['cards'][] = $card;

        // Disparar un evento para indicar que los datos han cambiado
        $this->dispatch('card-moved', [
            'cardId' => $cardId,
            'newStatus' => $newStatus
        ]);
    }

    public function render()
    {
        return view('livewire.recap-table');
    }
}
