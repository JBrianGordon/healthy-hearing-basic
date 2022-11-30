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
    * Create a group of checkbox inputs
    * @param string 'checkboxGroupName'
    * @param array 'fields'
    */
    public function checkboxGroup($checkboxGroupName, $checkboxFields=[]) {
        $formInput = '<div class="border mb-3 p-2">';
        $formInput .= '<label class="mb-2"><strong>'.$checkboxGroupName.'</strong></label>';
        $formInput .= '<div class="row">';
        foreach ($checkboxFields as $field) {
            $formInput .= '<div class="mb-1 col-md-6">';
            $label = ['text' => $field['label'], 'class' => 'small'];
            $formInput .= $this->formInput($field['field'], 'boolean', $field['label'], false, false, $field['value']);
            $formInput .= '</div>';
        }
        $formInput .= '</div></div>';
        return $formInput;
    }

    /**
    * Create a custom form control based on type
    * @param string 'field'
    * @param string 'type'
    */
    public function formInput($field, $type, $label=null, $options=false, $empty=false, $value=null) {
        $fieldSlug = mb_strtolower(Text::slug($field, '-'));
        $labelClass = isset($label['class']) ? $label['class'] : "";
        $label = isset($label['text']) ? $label['text'] : $label;
        $label = $label ?: ucfirst(strtolower(Inflector::humanize($field)));
        $formInput = '';
        switch ($type) {
            case 'select':
                $formInput = $this->Form->control($field, [
                    'type' => 'select',
                    'options' => $options,
                    'empty' => $empty,
                    'label' => ['text' => $label],
                    'multiple' => null,
                ]);
                break;
            case 'selectMultiple':
                $formInput = $this->Form->control($field, [
                    'type' => 'select',
                    'options' => $options,
                    'empty' => $empty,
                    'label' => $label,
                    'multiple' => true,
                ]);
                break;
            case 'boolean':
                // TODO: Make this a prettier 3-way switch
                $formInput .= '<label class="float-start col-md-5 tar '.$labelClass.'" style="max-width:75%;">'.$label.'</label>';
                $formInput .= '<input name="'.$field.'" class="form-control" placeholder="0 [or] 1" type="text" id="'.$label.'">';
                break;
            case 'datetime':
            case 'date':
                $startValue = isset($value['start']) ? $value['start'] : null;
                $endValue = isset($value['end']) ? $value['end'] : null;
                $formInput .= '<div class="input-group">';
                $formInput .= '<label class="form-check-label col-md-5 tar" for="'.$fieldSlug.'">'.$label.'</label>';
                $formInput .= '<input class="form-control" type="date" id="'.$fieldSlug.'-start" name="'.$field.'_start" value='.$startValue.'>';
                $formInput .= '<span>&nbsp; - &nbsp;</span>';
                $formInput .= '<input class="form-control" type="date" id="'.$fieldSlug.'-end" name="'.$field.'_end" value='.$endValue.'>';
                $formInput .= '</div>';
                break;
            default: //string, integer, biginteger
                $formInput = $this->Form->control($field, [
                    'type' => 'text',
                    'label' => ['text' => $label],
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
