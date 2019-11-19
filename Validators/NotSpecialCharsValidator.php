<?php

namespace BasicApp\Validators;

class NotSpecialCharsValidator
{

    public function not_special_chars($str, & $tags = null, $data = null, string & $error = null) : bool
    {
        $new_string = htmlspecialchars($str, $tags);

        if ($str != $new_string)
        {
            $error = t('errors', 'Special chars is not allowed.');
         
            if ($data === null)
            {
                $tags = $error;
            }

            return false;
        }

        return true;
    }

}