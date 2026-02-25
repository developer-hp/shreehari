<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getsettings()
    {
        return CHtml::listData(Setting::model()->findAll(),'title','content');
    }

    /**
     * Read field value with basic datatype normalization and fallback default.
     */
    public function getTypedFieldValue(array $source, $key, $type = 'string', $default = null)
    {
        if (!array_key_exists($key, $source)) {
            return $default;
        }

        $value = $source[$key];
        $type = strtolower((string) $type);

        switch ($type) {
            case 'array':
                return is_array($value) ? $value : $default;

            case 'int':
            case 'integer':
                if ($value === '' || $value === null) {
                    return $default;
                }
                return is_numeric($value) ? (int) $value : $default;

            case 'float':
            case 'double':
            case 'numeric':
                if ($value === '' || $value === null) {
                    return $default;
                }
                return is_numeric($value) ? (float) $value : $default;

            case 'trimmed_string':
                if ($value === null) {
                    return $default;
                }
                return trim((string) $value);

            case 'string':
            default:
                if ($value === null) {
                    return $default;
                }
                return (string) $value;
        }
    }

}
