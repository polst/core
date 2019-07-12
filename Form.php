<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

class Form
{

    public function __construct()
    {
        helper(['form']);
    }

    public function open(string $action = '', $attributes = [], array $hidden = []): string
    {
        return form_open($action, $attributes, $hidden);
    }

    public function openMultipart(string $action = '', $attributes = [], array $hidden = []): string
    {
        return form_open_multipart($action, $attributes, $hidden);
    }

    public function hidden($name, $value = '', bool $recursing = false): string
    {
        return form_hidden($name, $value, $recursing);
    }

    public function input($data = '', string $value = '', $extra = '', string $type = 'text'): string
    {
        return form_input($data, $value, $extra, $type);
    }

    public function password($data = '', string $value = '', $extra = ''): string
    {
        return form_password($data, $value, $extra);
    }

    public function upload($data = '', string $value = '', $extra = ''): string
    {
        return form_upload($data, $value, $extra);
    }

    public function textarea($data = '', string $value = '', $extra = ''): string
    {
        return form_textarea($data, $value, $extra);
    }

    public function multiselect(string $name = '', array $options = [], array $selected = [], $extra = ''): string
    {
        return form_multiselect($name, $options, $selected, $extra);
    }

    public function dropdown($data = '', $options = [], $selected = [], $extra = ''): string
    {
        return form_dropdown($data, $options, $selected, $extra);
    }

    public function checkbox($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        return form_checkbox($data, $value, $checked, $extra);
    }

    public function radio($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        return form_radio($data, $value, $checked, $extra);
    }

    public function submit($data = '', string $value = '', $extra = ''): string
    {
        return form_submit($data, $value, $extra);
    }

    public function reset($data = '', string $value = '', $extra = ''): string
    {
        return form_reset($data, $value, $extra);
    }

    public function button($data = '', string $content = '', $extra = ''): string
    {
        return form_button($data, $content, $extra);
    }
  
    public function label(string $label_text = '', string $id = '', array $attributes = []): string
    {
        return form_label($label_text, $id, $attributes);
    }

    public function datalist(string $name, string $value, array $options): string
    {
        return form_datalist($name, $value, $options);
    }

    public function fieldset(string $legend_text = '', array $attributes = []): string
    {
        return form_fieldset($legend_text, $attributes);
    }

    public function fieldsetClose(string $extra = ''): string
    {
        return form_fieldset_close($extra);
    }

    public function close(string $extra = ''): string
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