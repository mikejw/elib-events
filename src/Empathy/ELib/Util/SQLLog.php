<?php

namespace Empathy\ELib\Util;

use Empathy\ELib\YAML;

class SQLLog
{
    public static function log($data)
    {
        $queries = YAML::load(DOC_ROOT.'/logs/sql_log');
        $queries[] = $data;
        YAML::save($queries, DOC_ROOT.'/logs/sql_log');
    }

}
