<?php

namespace Va\CutletHelper\View\Components;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Va\CutletHelper\Facades\CategoryHelperFacade;

class CategoryOptions extends Component
{
    /**
     * The type of menu, modules or manager
     * @var
     */
    public $page;

    public $selected;

    public function __construct($page,$selected = '')
    {
        // Set input variables to generate a component
        $this->page = $page;
        $this->selected = $selected;
    }

    public function render()
    {
        switch ($this->page){
            case 'create':
                return CategoryHelperFacade::category_select_options($this->categories(), old('parent_id'));
            case 'edit':
                return '';
        }
    }

    public function categories()
    {
        return Category::all();
    }
}
