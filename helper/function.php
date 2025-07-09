<?php 
class HelperFunction{
       // lấy URL hiện hành 
    function getBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST'];
        $scriptDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $scriptDir = rtrim($scriptDir, '/');

        return $protocol . $host . $scriptDir;
    }
}