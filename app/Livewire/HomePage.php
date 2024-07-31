<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home Page - Shopmania')]
class HomePage extends Component
{
    public function render()
    {

        return view('livewire.home-page')
        ->layout('components.layouts.app');
    }
}
