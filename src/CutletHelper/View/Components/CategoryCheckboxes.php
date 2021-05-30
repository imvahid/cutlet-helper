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

    public $create_html, $edit_html;

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
                $this->create_html = CategoryHelperFacade::category_checkboxes($this->categories(), old('categories'), $prefix="");
                return view('vendor.cutlet-helper.category-checkbox-create');
            case 'edit':
                $this->checked = str_replace('[', '', $this->checked);
                $this->checked = str_replace(']', '', $this->checked);
                $this->checked = explode( ",", $this->checked );
                $this->edit_html = CategoryHelperFacade::category_checkboxes($this->categories(), old( 'categories', $this->checked ), $prefix="" );
                return view('vendor.cutlet-helper.category-checkbox-edit');
        }
    }

    public function categories()
    {
        return Category::where('parent_id', 0)
            ->where('category_type', $this->type)
            ->get();
    }
}
