<?php namespace Jaffle\Tools;

use Exception;

trait ConfigWriter
{

    protected function replaceConfigValue($path, $key, $value)
    {
        if(strpos($value, "'") !== FALSE ){
            throw new Exception('I dont think string replacement is supported by the current regular expression');
        };

        $contents = app('files')->get($path);

        $pattern = sprintf('/([\'"]%s[\'"]\s*\=>\s*)(.*),?/', $key);

        $replacement = '$1' . $value . ',';

        $matches = [];

        preg_match_all($pattern, $contents, $matches);

        $contents = preg_replace($pattern, $replacement, $contents);

        app('files')->put($path, $contents);
    }

}