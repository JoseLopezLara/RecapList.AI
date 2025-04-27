<?php

namespace App\Livewire;

use Livewire\Component;

class RecapTestComponent extends Component
{
    public $testTitle = 'Test Title';
    public $testContent = 'This is a test content to see if text displays correctly';

    public function render()
    {
        return view('livewire.recap-test-component');
    }
}
