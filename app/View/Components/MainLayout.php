<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    // Esto reenderiza el layout que queremos.
    public function render(): View|Closure|string
    {
        return view('layouts.main-layout');
    }
}
