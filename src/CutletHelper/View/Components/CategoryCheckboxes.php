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

    public $checked;

    public function __construct($type,$page,$checked = '')
    {
        // Set input variables to generate a component
        $this->type = $type;
        $this->page = $page;
        $this->checked = $checked;
    }

    public function render()
    {
        switch ($this->page){
            case 'create':
                return CategoryHelperFacade::category_checkboxes($this->categories(), old('categories'), $prefix="");
            case 'edit':
                $this->checked = str_replace('[', '', $this->checked);
                $this->checked = str_replace(']', '', $this->checked);
                $this->checked = str_replace(',', '', $this->checked);
                return CategoryHelperFacade::category_checkboxes($this->categories(), old( 'categories', str_split($this->checked) ), $prefix="" );
        }
    }

    public function categories()
    {
        return Category::where('parent_id', 0)
            ->where('category_type', $this->type)
            ->get();
    }
}
