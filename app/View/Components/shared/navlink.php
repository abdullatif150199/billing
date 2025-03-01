<?php

namespace App\View\Components\shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navlink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $route,
        public string $icon,
        public ?bool $border = false,
        public string $name,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.navlink');
    }
}
