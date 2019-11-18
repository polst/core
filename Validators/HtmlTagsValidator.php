<?php

namespace BasicApp\Validators;

class HtmlTagsValidator
{

    /*
    public function even(string $str, string &$error = null): bool
    {
        if ((int)$str % 2 != 0)
        {
            $error = lang('myerrors.evenError');
            return false;
        }

        return true;
    }
    */

    public function html_tags($str, string $tags, array $data): bool
    {
        $new_string = strip_tags($str, $tags);

        if ($str != $new_string)
        {
            return false;
        }

        return true;
    }

}