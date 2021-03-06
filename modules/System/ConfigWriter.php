<?php

namespace Modules\System;

use Exception;

/**
 * Class ConfigWriter
 * @package Modules\System
 */
trait ConfigWriter
{
    /**
     * @param $path
     * @param $key
     * @param $value
     * @throws Exception
     */
    protected function replaceConfigValue($path, $key, $value)
    {
        if (strpos($value, "'") !== false) {
            throw new Exception('I dont think string replacement is supported by the current regular expression');
        };

        $contents = app('files')->get($path);

        $pattern = sprintf('/([\'"]%s[\'"]\s*\=>\s*)(.*),?/', $key);

        $replacement = '$1'.$value.',';

        $matches = [];

        preg_match_all($pattern, $contents, $matches);

        $contents = preg_replace($pattern, $replacement, $contents);

        app('files')->put($path, $contents);
    }
}
