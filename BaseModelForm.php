<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Core\Html;

abstract class BaseModelForm extends Form
{

    use FactoryTrait;

    public $model = null;

    public $errors = [];

    // error

    public $errorTag = 'div';

    public $defaultErrorOptions = [
        'class' => 'alert alert-danger', 
        'role' => 'alert'
    ];

    // group    

    public $groupTemplate = '{label}{input}';

    public $groupTag = 'div';

    public $defaultGroupOptions = [];

    // inputs

    public $defaultLabelOptions = [];

    public $defaultInputOptions = [];

    public $defaultTextareaOptions = [];

    public $defaultPasswordOptions = [];

    public $defaultCheckboxOptions = [];

    public $defaultDropdownOptions = [];

    public $defaultMultiselectOptions = [];

    public $defaultUploadOptions = [];

    // buttons

    public $defaultButtonOptions = [];

    public $defaultResetOptions = [];

    public $defaultSubmitOptions = [];

    public function attributeError($attribute, $options = [])
    {
        if (array_key_exists('error', $options))
        {
            return $options['error'];
        }

        if (array_key_exists($attribute, $this->errors))
        {
            return $this->errors[$attribute];
        }

        return '';
    }

    public function attributeName($attribute, $options = [])
    {
        if (array_key_exists('name', $options))
        {
            return $options['name'];
        }

        return $attribute;
    }

    public function attributeLabel($attribute, $options = [])
    {
        if (array_key_exists('label', $options))
        {
            return $options['label'];
        }

        return $this->model->label($attribute);
    }

    public function attributeValue($attribute, $options = [])
    {
        if (array_key_exists('value', $options))
        {
            return $options['value'];
        }

        $value = $this->model->{$attribute};

        return (string)$value;
    }

    public function group($attribute, $input, $options = [])
    {
        if ($options === false)
        {
            return $input;
        }

        $options = Html::mergeOptions($this->defaultGroupOptions, $options);

        if (array_key_exists('template', $options))
        {
            $template = $options['template'];

            unset($options['template']);
        }
        else
        {
            $template = $this->groupTemplate;
        }

        $label = $this->attributeLabel($attribute, $options);

        $labelOptions = ArrayHelper::getValue($options, 'labelOptions', []);

        $labelOptions = Html::mergeOptions($labelOptions, $this->defaultLabelOptions);

        $label = $this->label($label, $labelOptions);

        $error = $this->attributeError($attribute, $options);

        $params = [
            '{input}' => $input,
            '{label}' => $label,
            '{error}' => $error
        ];

        $content = strtr($template, $params);

        return Html::tag($this->groupTag, $content, $options);
    }

    public function label($label, array $options = [])
    {
        return Html::tag('label', $label, $options);
    }

    public function input($attribute, array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultInputOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formInput($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function textarea($attribute, array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultTextareaOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formTextarea($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }    

    public function password($attribute, array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultPasswordOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formPassword($name, '', $options);
    
        return $this->group($attribute, $return, $groupOptions);
    }

    public function checkbox($attribute, array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultCheckboxOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        if (array_key_exists('uncheck', $options) && ($options['uncheck'] === false))
        {
            $uncheck = '';
        }
        else
        {
            $uncheck = $this->formHidden($name, 0);
        }

        $return = $uncheck . $this->formCheckbox($name, 1, (bool) $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function dropdown($attribute, array $items = [], array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultInputOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formDropdown($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function multiselect($attribute, array $items = [], array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultInputOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formMiltiselect($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function upload($attribute, array $options = [], $groupOptions = [])
    {
        $options = Html::mergeOptions($this->defaultUploadOptions, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formUpload($name, '', $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    // errors and buttons

    public function submit($label, array $options = [])
    {
        $options = Html::mergeOptions($this->defaultSubmitOptions, $options);

        $name = $this->attributeName('submit', $options);

        return $this->formSubmit($name, $label, $options);
    }

    public function button($label, array $options = [])
    {
        $options = Html::mergeOptions($this->defaultButtonOptions, $options);

        $name = $this->attributeName(null, $options);

        return $this->formButton($name, $label, $options);
    }

    public function reset($label, array $options = [])
    {
        $options = Html::mergeOptions($this->defaultResetOptions, $options);

        $name = $this->attributeName('reset', $options);

        return $this->formReset($name, $label, $options);
    }

    public function error($error, $options = [])
    {
        $options = Html::mergeOptions($this->defaultErrorOptions, $options);

        return Html::tag($this->errorTag, $options);
    }

    public function errors($options = [])
    {
        $return = '';

        foreach($this->errors as $error)
        {
            $return .= $this->error($error, $options);
        }

        return $return;
    }

}