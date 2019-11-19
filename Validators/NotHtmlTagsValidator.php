<?php

namespace BasicApp\Validators;

class NotHtmlTagsValidator
{

    public function not_html_tags($str, string & $error = null) : bool
    {
        $new_string = strip_tags($str, $tags);

        if ($str != $new_string)
        {
            $error = t('errors', 'HTML tags is not allowed.');
         
            return false;
        }

        return true;
    }

}