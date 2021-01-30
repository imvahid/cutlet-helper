<?php

namespace Va\CutletHelper\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategorySelect extends Component
{
    /**
     * The type of menu, modules or manager
     * @var
     */
    public $categories;

    public function __construct()
    {
        // Set input variables to generate a component
    }

    public function render()
    {
        dd($this->categories);
    }
}
