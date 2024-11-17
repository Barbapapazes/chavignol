<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BlogLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    // @codeCoverageIgnoreStart
    public function render(): View
    {
        return view('layouts.blog');
    }
    // @codeCoverageIgnoreEnd
}
