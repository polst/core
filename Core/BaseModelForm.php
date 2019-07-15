<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Helpers\ArrayHelper;
use BasicApp\Traits\FactoryTrait;

abstract class BaseModelForm extends Form
{

    use FactoryTrait;

    public $model = null;

    public $errors = [];

    public $errorClass = 'is-invalid';

    public $groupErrorClass;

    public $groupTemplate = '{label}{input}';

    public $errorOptions = [
        'class' => 'alert alert-danger',
        'role' => 'alert'
    ];

    public $groupOptions = [
        'class' => 'form-group'
    ];

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


        if ($this->hasError($attribute))
        {
            $options = $this->addClass($options, $this->groupErrorClass);
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

        $content = strtr($template, $params);

        $options = ArrayHelper::getValue($options, 'options', $this->groupOptions);

        return '<div ' .stringifly_attributes($options) . '>' . $content. '</div>';
    }

    public function label($label, array $options = [])
    {
        return Html::tag('label', $label, $options);
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

    public function input($attribute, array $options = [], $groupOptions = [])
    {
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formInput($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function textarea($attribute, array $options = [], $groupOptions = [])
    {
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formTextarea($name, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }    

    public function password($attribute, array $options = [], $groupOptions = [])
    {
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formPassword($name, '', $options);
    
        return $this->group($attribute, $return, $groupOptions);
    }

    public function checkbox($attribute, array $options = [], $groupOptions = [])
    {
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
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formDropdown($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function multiselect($attribute, array $items = [], array $options = [], $groupOptions = [])
    {
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $value = $this->attributeValue($attribute, $options);

        $return = $this->formMiltiselect($name, $items, $value, $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    public function upload($attribute, array $options = [], $groupOptions = [])
    {
        $options = $this->addErrorClass($attribute, $options);

        $name = $this->attributeName($attribute, $options);

        $return = $this->formUpload($name, '', $options);

        return $this->group($attribute, $return, $groupOptions);
    }

    // errors and buttons

    public function submit($label, array $options = [])
    {
        $name = $this->attributeName('submit', $options);

        return $this->formSubmit($name, $label, $options);
    }

    public function button($label, array $options = [])
    {
        $name = $this->attributeName(null, $options);

        return $this->formButton($name, $label, $options);
    }

    public function reset($label, array $options = [])
    {
        $name = $this->attributeName('reset', $options);

        return $this->formReset($name, $label, $options);
    }

    public function error($error, $options = [])
    {
        if (!$options)
        {
            $options = $this->errorOptions;
        }

        return '<div ' . stringifly_attributes($options) . '>' . $error . '</div>';
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

    public function hasError($attribute)
    {
        if ($this->attributeError($attribute))
        {
            return true;
        }

        return false;
    }

}