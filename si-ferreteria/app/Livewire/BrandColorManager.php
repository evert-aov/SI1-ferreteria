<?php

namespace App\Livewire;

use Livewire\Component;

class BrandColorManager extends Component
{

    public $color;
    public function render()
    {
        return view('livewire.brand-color-manager');
    }
}
