<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    public function __construct(
        public string $route,
        public string $icon = 'squares',
        public int $badge = 0,
    ) {}

    public function render()
    {
        return view('components.nav-link');
    }
}
