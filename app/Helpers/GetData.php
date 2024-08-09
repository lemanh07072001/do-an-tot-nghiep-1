<?php


namespace App\Helpers;

use App\Models\User;


class GetData
{
    public static function showCategoriesSelect($categories, $old = '', $module = null)
    {
        // Attempt to get the module's ID from the request route
        $id = $module ? optional(request()->route($module))->id : null;

        foreach ($categories as $item) {
            // Determine if this category should be selected
            $selected = ($old == $item->id) ? 'selected' : '';

            // Skip categories where parent_id matches the module's ID
            echo '<option value="' . $item->id . '" ' . $selected . '>';
            echo str_repeat('|---', $item->depth) . $item->name;
            echo '</option>';
        }
    }


    public static function showPropertiesSelect($properties, $old = '', $module = null)
    {
        // Attempt to get the module's ID from the request route
        $id = $module ? optional(request()->route($module))->id : null;

        foreach ($properties as $item) {
            // Determine if this category should be selected
            $selected = ($old == $item->id) ? 'selected' : '';

            // Skip categories where parent_id matches the module's ID
            echo '<option value="' . $item->id . '" ' . $selected . '>';
            echo str_repeat('|---', $item->depth) . $item->name;
            echo '</option>';
        }
    }
}
