<?php

namespace Va\CutletHelper\Helpers;

use Illuminate\Support\Facades\Route;

class CategoryHelper
{
    function category_select_options($categories, $current = "", $edit_id = "" ,$prefix = "")
    {
        $response = "";
        if ($edit_id != ""){
            $categories = $categories->except($edit_id);
        }
        foreach ($categories as $category) {
            $selected = ($category->id == $current) ? "selected='selected'" : "";
            $title = $category->title;
            if ($prefix != "")
                $title = $prefix . " " . $title;
            $response .= "<option value='{$category->id}' {$selected}>{$title}</option>";

            if ($category->has('children'))
                $response .= $this->category_select_options($category->children, $current, $edit_id,$prefix . "--");
        }

        return $response;
    }

    function category_checkboxes($categories, $current, $prefix="")
    {
        $response = $this->category_checkbox_item_generator($categories, $current, $prefix="");
        return '<div style="margin-right: -30px">' . $response . '</div>';
    }

    function category_checkbox_item_generator($categories, $current, $prefix="") {
        ($current == null) ? $current = [] : $current;

        $response = "<ul style='list-style: none;'>";

        foreach ($categories as $category)
        {
            $checked = ( in_array( $category->id, $current ) ) ? "checked='checked'" : "";
            $title = $category->title;
            $response .= "<li><div class='custom-control custom-checkbox'>
                {$prefix}<input type='checkbox' class='custom-control-input' name='categories[]' id='category_{$category->id}' value='{$category->id}' {$checked}>
                <label class='custom-control-label' for='category_{$category->id}'>{$title}</label></div></li>";

            if ($category->has('children'))
                $response .= $this->category_checkbox_item_generator($category->children, $current, $prefix);
        }
        $response .= "</ul>";
        return $response;
    }
}
