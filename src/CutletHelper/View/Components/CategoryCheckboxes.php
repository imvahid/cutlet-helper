<?php

namespace Va\CutletHelper\View\Components;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Va\CutletHelper\Facades\CategoryHelperFacade;

class CategoryCheckboxes extends Component
{
    /**
     * The type of menu, modules or manager
     * @var
     */
    public $type;

    public $page;

    public function __construct($type,$page)
    {
        // Set input variables to generate a component
        $this->type = $type;
        $this->page = $page;
    }

    public function render()
    {
        switch ($this->page){
            case 'create':
                return CategoryHelperFacade::category_checkboxes($this->categories(), old('categories'), $prefix="");
            case 'edit':
                return CategoryHelperFacade::category_checkboxes($this->categories(), old('categories'), $prefix="");
        }
    }

    public function categories()
    {
        return Category::where('parent_id', 0)
            ->where('category_type', $this->type)
            ->get();
    }
}
