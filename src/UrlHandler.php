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
        $get = null;
        do {
            $count = count($args);
            if($count == 0)
                break;
            $pattern = "(<[^/]*>)";
            $pr = preg_match_all($pattern, $url, $matches);
            if(is_array($args[$count -1]))
            {
                $get = array_pop($args);
                $get = http_build_query($get);
            }
            if($pr == 0)
                break;
            $matches = $matches[0];
            $url = str_replace($matches, $args, $url);
        }while(false);
        if($get != null)
            $url = $url . '?' . $get;
        return self::$prefix . $url;
    }
    
    public static function removePrefix($url)
    {
        return str_ireplace(self::$prefix, '', $url);
    }
}