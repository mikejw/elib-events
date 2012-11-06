<?php

namespace Empathy\ELib;

use Empathy\MVC\Model as EmpModel;

class Model extends EmpModel
{

    public static function load($model, $host = null, $connect=true)
    {
        $storage_object = null;

        $file = $model.'.php';

        $app_file = DOC_ROOT.'/storage/'.$file;

        if (!file_exists($app_file)) {
            $class = 'ELib\\Storage\\'.$model;
        } else {
            $class = '\\Empathy\\Model\\'.$model;
        }
        $storage_object = new $class();

        if ($connect) {
            self::connectModel($storage_object, $host);
        }

        return $storage_object;
    }

    public static function getTable($model)
    {
        $file = $model.'.php';
        $app_file = DOC_ROOT.'/storage/'.$file;

        if (!file_exists($app_file)) {
            $class = 'ELib\\Storage\\'.$model;
        } else {
            $class = '\\Empathy\\Model\\'.$model;
        }

        return $class::TABLE;
    }

}
