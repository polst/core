<?php
/**
 * @author Basic App Dev Team <dev@basic-app.con>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

trait LanguageTrait
{

    public function getLanguageLine(string $value, array $params = []) : string
    {
        if (property_exists($this, 'languageCategory'))
        {
            if ($this->languageCategory === false)
            {
                return strtr($value, $params);
            }

            if ($this->languageCategory)
            {
                return t($this->languageCategory, $value, $params);
            }
        }
    
        return lang($value, $params);
    }

}