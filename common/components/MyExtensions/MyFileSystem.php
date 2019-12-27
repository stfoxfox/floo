<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 19.07.15
 * Time: 17:37
 */

namespace common\components\MyExtensions;
use Yii;


class MyFileSystem {
    public static function makeDirs($path, $mode = 0755, $recursive = true)
    {
        $dir = substr($path, 0, strrpos($path, '/'));
        if (!file_exists($dir)) {
            mkdir($dir, $mode, $recursive);
        }
        return $path;
    }

    public static function readDir($path)
    {
        $files = array();
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }
} 