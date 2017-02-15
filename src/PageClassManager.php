<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/14
 * Time: 16:48
 */

namespace flwt;


class PageClassManager
{
    protected static $groupArr;
    protected static $objectArr;
    const DEFAULT_GROUP = "default";
    protected static $currentGroup = self::DEFAULT_GROUP;

    /**
     * @param mixed $currentGroup
     */
    public static function setCurrentGroup($currentGroup)
    {
        self::$currentGroup = $currentGroup;
    }

    public static function addClass($className, $group = null)
    {
        if($group == null)
        {
            $group = self::$currentGroup;
        }
        if(!is_array(self::$groupArr) )
        {
            self::$groupArr = array();
        }
        
        if(!isset(self::$groupArr[$group]))
        {
            self::$groupArr[$group] = array();
        }
        if(!in_array($className, self::$groupArr[$group]))
        {
            self::$groupArr[$group][] = $className;
        }
    }
    
    public static function map($url)
    {
        if(!is_array(self::$groupArr) || !isset(self::$groupArr[self::$currentGroup]))
            return null;
        
        foreach (self::$groupArr[self::$currentGroup] as $className)
        {
            if (!isset(self::$objectArr[$className])) {
                $object = new $className();
                self::$objectArr[$className] = $object;
            }


            $object = self::$objectArr[$className];

            if($object->matchUrl($url))
            {
                return $className;
            }
            
        }
        return null;
        
    }


}