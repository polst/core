<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Helpers\ArrayHelper;
use BasicApp\Traits\FactoryTrait;

abstract class BaseForm
{

    use FactoryTrait;

    public $model = null;

    public $errors = [];

    public $messages = [];

    public $errorClass = 'is-invalid';

    public $groupErrorClass;

    public $groupTemplate = '{label}{input}';

    public $defaultGroupOptions = ['class' => 'form-group'];

    public $defaultLabelOptions = [];

    public $defaultInputOptions = [];

    public $defaultTextareaOptions = [];

    public $defaultPasswordOptions = [];

    public $defaultCheckboxOptions = [];

    public $defaultDropdownOptions = [];

    public $defaultMultiselectOptions = [];

    public $defaultUploadOptions = [];

    public $defaultSubmitOptions = [];

    public $defaultButtonOptions = [];

    public $defaultResetOptions = [];

    public $defaultErrorOptions = ['class' => 'alert alert-danger', 'role' => 'alert'];

    public $defaultMessageOptions = ['class' => 'alert alert-info', 'role' => 'alert'];

    public function __construct()
    {
        helper(['form']);
    }

    public function group($attribute, $input, $options = [])
    {
        if ($options === false)
        {
            return $input;
        }

        $options = $this->addErrorClass($attribute, $options, $this->groupErrorClass);

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

        $label = $this->label($label, $labelOptions);

        $error = $this->attributeError($attribute, $options);

        $params = [
            '{input}' => $input,
            '{label}' => $label,
            '{error}' => $error
        ];

        $prefix = ArrayHelper::getValue($options, 'prefix');

        $suffix = ArrayHelper::getValue($options, 'suffix');

        $content = $prefix . strtr($template, $params) . $suffix;

        $options = ArrayHelper::getValue($options, 'options', $this->defaultGroupOptions);

        return '<div ' .stringify_attributes($options) . '>' . $content. '</div>';
    }

    public function label($label, array $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultLabelOptions;
        }

        return '<label ' . stringify_attributes($options) . '>' . $label . '</label>';
    }

    public function input($attribute, array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultInputOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formInput($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function textarea($attribute, array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultTextareaOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formTextarea($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }    

    public function password($attribute, array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultPasswordOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formPassword($name, '', $options);
    
        return $this->group($attribute, $return, $groupOptions);
    }

    public function checkbox($attribute, array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultCheckboxOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

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
        if (!$options)
        {
            $options = $this->defaultDropdownOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formDropdown($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function multiselect($attribute, array $items = [], array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultMultiselectOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formMiltiselect($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function upload($attribute, array $options = [], $groupOptions = [])
    {
        if (!$options)
        {
            $options = $this->defaultUploadOptions;
        }

        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formUpload($name, '', $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    // errors and buttons

    public function submit($label, array $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultSubmitOptions;
        }

        $name = $this->attributeName('submit', $options);

        return $this->formSubmit($name, $label, $options);
    }

    public function button($label, array $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultButtonOptions;
        }

        $name = $this->attributeName(null, $options);

        return $this->formButton($name, $label, $options);
    }

    public function reset($label, array $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultResetOptions;
        }

        $name = $this->attributeName('reset', $options);

        return $this->formReset($name, $label, $options);
    }

    public function error($error, $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultErrorOptions;
        }

        return '<div ' . stringify_attributes($options) . '>' . $error . '</div>';
    }

    public function message($error, $options = [])
    {
        if (!$options)
        {
            $options = $this->defaultMessageOptions;
        }

        return '<div ' . stringify_attributes($options) . '>' . $error . '</div>';
    }

    public function renderErrors($options = [])
    {
        $return = '';

        foreach($this->errors as $error)
        {
            $return .= $this->error($error, $options);
        }

        return $return;
    }

    public function renderMessages($options = [])
    {
        $return = '';

        foreach($this->messages as $message)
        {
            $return .= $this->message($message, $options);
        }

        return $return;
    }    

    public function hasError($attribute)
    {
        if ($this->attributeError($attribute))
        {
            return true;
        }

        return false;
    }

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

    public function addErrorClass($attribute, array $options, $errorClass = null)
    {
        if ($errorClass === null)
        {
            $errorClass = $this->errorClass;
        }

        if ($errorClass && $this->hasError($attribute))
        {
            if (!array_key_exists('class', $options))
            {
                $options['class'] = $this->errorClass;
            }
            else
            {
                $options['class'] .= ' ' . $this->errorClass;
            }
        }

        return $options;
    }

    // helper

    public function formOpen(string $action = '', $attributes = [], array $hidden = []): string
    {
        return form_open($action, $attributes, $hidden);
    }

    public function formOpenMultipart(string $action = '', $attributes = [], array $hidden = []): string
    {
        return form_open_multipart($action, $attributes, $hidden);
    }

    public function formHidden($name, $value = '', bool $recursing = false): string
    {
        return form_hidden($name, $value, $recursing);
    }

    public function formInput($data = '', string $value = '', $extra = '', string $type = 'text'): string
    {
        return form_input($data, $value, $extra, $type);
    }

    public function formPassword($data = '', string $value = '', $extra = ''): string
    {
        return form_password($data, $value, $extra);
    }

    public function formUpload($data = '', string $value = '', $extra = ''): string
    {
        return form_upload($data, $value, $extra);
    }

    public function formTextarea($data = '', string $value = '', $extra = ''): string
    {
        return form_textarea($data, $value, $extra);
    }

    public function formMultiselect(string $name = '', array $options = [], array $selected = [], $extra = ''): string
    {
        return form_multiselect($name, $options, $selected, $extra);
    }

    public function formDropdown($data = '', $options = [], $selected = [], $extra = ''): string
    {
        return form_dropdown($data, $options, $selected, $extra);
    }

    public function formCheckbox($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        return form_checkbox($data, $value, $checked, $extra);
    }

    public function formRadio($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        return form_radio($data, $value, $checked, $extra);
    }

    public function formSubmit($data = '', string $value = '', $extra = ''): string
    {
        return form_submit($data, $value, $extra);
    }

    public function formReset($data = '', string $value = '', $extra = ''): string
    {
        return form_reset($data, $value, $extra);
    }

    public function formButton($data = '', string $content = '', $extra = ''): string
    {
        return form_button($data, $content, $extra);
    }
  
    public function formLabel(string $label_text = '', string $id = '', array $attributes = []): string
    {
        return form_label($label_text, $id, $attributes);
    }

    public function formDatalist(string $name, string $value, array $options): string
    {
        return form_datalist($name, $value, $options);
    }

    public function formFieldset(string $legend_text = '', array $attributes = []): string
    {
        return form_fieldset($legend_text, $attributes);
    }

    public function formFieldsetClose(string $extra = ''): string
    {
        return form_fieldset_close($extra);
    }

    public function formClose(string $extra = ''): string
    {
        return form_close($extra);
    }

    public function setValue(string $field, string $default = '', bool $html_escape = true): string
    {
        return set_value($field, $default, $html_escape);
    }

    public function setSelect(string $field, string $value = '', bool $default = false): string
    {
        return set_select($field, $value, $default);
    }

    public function setCheckbox(string $field, string $value = '', bool $default = false): string
    {
        return set_checkbox($field, $value, $default);
    }

    public function setRadio(string $field, string $value = '', bool $default = false): string
    {
        return set_radio($field, $value, $default);
    }    

}