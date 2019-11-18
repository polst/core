<?php

namespace BasicApp\Validators;

class HtmlTagsValidator
{

    public function html_tags($str, & $tags = null, $data = null, string & $error = null) : bool
    {
        $new_string = strip_tags($str, $tags);

        if ($str != $new_string)
        {
            if (!$tags)
            {
                $error = t('errors', 'HTML tags not allowed.');
            }
            else
            {
                $error = t('errors', 'HTML tags allowed: {tags}', ['{tags}' => esc($tags)]);
            }

            if ($data === null)
            {
                $tags = $error;
            }

            return false;
        }

        return true;
    }

}