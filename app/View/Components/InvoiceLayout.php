<?php

namespace App\View\Components;

use Closure;
use Livewire\Attributes\On;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class InvoiceLayout extends Component
{
    /**
     * Create a new component instance.
     */
    protected $listeners = [
        'update-font' => '$refresh'
    ];

    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */

    public function render(): View|Closure|string
    {
        return view('components.invoice-layout');
    }
}
