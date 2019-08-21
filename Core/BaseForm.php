<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Helpers\Url;

abstract class BaseForm
{

    public function __construct()
    {
        helper(['form']);
    }

    public function formOpen($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = Url::currentUrl();
        }

        return form_open($action, $attributes, $hidden);
    }

    public function formOpenMultipart($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = Url::currentUrl();
        }

        return form_open_multipart($action, $attributes, $hidden);
    }

    public function formHidden($name, $value = '', bool $recursing = false): string
    {
        return form_hidden($name, $value, $recursing);
    }

    public function formInput($data = '', string $value = '', $extra = '', string $type = 'text'): string
    {
        if (is_array($extra))
        {
            if (array_key_exists('type', $extra))
            {
                $type = $extra['type'];
            }
        }

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