<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

/**
 * Admin helper
 */
class AdminHelper extends Helper
{
/**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Form'];

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

    /**
    * Create a custom form control based on type
    * @param string 'field'
    * @param string 'type'
    */
    public function formInput($field, $type, $label=null, $options=false, $empty=false) {
        $fieldSlug = mb_strtolower(Text::slug($field, '-'));
        $label = $label ?: ucfirst(strtolower(Inflector::humanize($field)));
        $formInput = '';
        switch ($type) {
            case 'select':
                $formInput = $this->Form->control($field, [
                    'type' => 'select',
                    'options' => $options,
                    'empty' => $empty,
                    'label' => ['text' => $label, 'floating' => true],
                ]);
                break;
            case 'boolean':
                // TODO: Make this a prettier 3-way switch
                $formInput .= '<label class="col-md-4">'.$label.'</label>';
                $checked0 = (isset($queryParams[$field]) && empty($queryParams[$field])) ? 'checked' : '';
                $checked1 = (isset($queryParams[$field]) && !empty($queryParams[$field])) ? 'checked' : '';
                $checkedAll = (!isset($queryParams[$field])) ? 'checked' : '';
                $formInput .= '<div class="btn-group">';
                $formInput .= '<label class="btn btn-lg btn-outline-danger">';
                $formInput .= '<input type="radio" value="0" name="'.$field.'" id="'.$fieldSlug.'0" '.$checked0.'>&nbsp;';
                $formInput .= '</label>';
                $formInput .= '<label class="btn btn-lg btn-outline-secondary">';
                $formInput .= '<input type="radio" value="" name="'.$field.'" id="'.$fieldSlug.'All" '.$checkedAll.'>&nbsp;';
                $formInput .= '</label>';
                $formInput .= '<label class="btn btn-lg btn-outline-success">';
                $formInput .= '<input type="radio" value="1" name="'.$field.'" id="'.$fieldSlug.'1" '.$checked1.'>&nbsp;';
                $formInput .= '</label>';
                $formInput .= '</div>';
                break;
            case 'datetime':
            case 'date':
                $formInput .= '<div class="input-group">';
                $formInput .= '<label class="form-check-label col-md-4" for="'.$fieldSlug.'">'.$label.'</label>';
                $formInput .= '<input class="form-control" type="date" id="'.$fieldSlug.'-start">';
                $formInput .= '<span>&nbsp; - &nbsp;</span>';
                $formInput .= '<input class="form-control" type="date" id="'.$fieldSlug.'-end">';
                $formInput .= '</div>';
                break;
            default: //string, integer, biginteger
                $formInput = $this->Form->control($field, [
                    'type' => 'text',
                    'label' => ['text' => $label, 'floating' => true],
                ]);
                break;
        }
        return $formInput;
    }

    /**
    * Return Yes or No text based on boolean input
    * This is helpful when asking is_active
    * @param boolean
    * @return string of Yes or No
    */
    public function yesNo($boolean) {
        return $boolean ? "<span class='badge bg-success'><i class='bi bi-check-lg'></i> Yes</span>" : "<span class='badge bg-danger'><i class='bi bi-x-lg'></i> No</span>";
    }
}
