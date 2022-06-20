<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Admin helper
 */
class AdminHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
    * Inline ajax form to make fields editable on admin index pages
    * @param string 'Location.priority'
    */
    public function inlineAjax($modelfield, $data, $default = "edit"){
        list($model, $field) = explode(".", $modelfield);
        $id = $data->id;
        if ($id) {
            $value = $data->$field;
            if (empty($value)) {
                $value = $default;
            }
            return "<span class='inline_ajax' id='$model|$field|$id'>$value</span>";
        }
        return null;
    }
}
