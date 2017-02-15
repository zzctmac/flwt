<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/14
 * Time: 21:46
 */

namespace flwt;


class UrlHandler
{
    protected static $prefix;

    /**
     * @param mixed $prefix
     */
    public static function setPrefix($prefix)
    {
        self::$prefix = $prefix;
    }
    
    public static function getFullUrl($url, $args = array())
    {
        return self::$prefix . $url;
    }
    
    public static function removePrefix($url)
    {
        return str_ireplace(self::$prefix, '', $url);
    }
}