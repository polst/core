<?php

namespace BasicApp\Validators;

class HtmlSpecialCharsValidator
{

    public function html_special_chars($str, & $tags = null, $data = null, string & $error = null) : bool
    {
        $new_string = htmlspecialchars($str, $tags);

        if ($str != $new_string)
        {
            $error = t('errors', 'HTML special chars not allowed.');
         
            if ($data === null)
            {
                $tags = $error;
            }

            return false;
        }

        return true;
    }

}