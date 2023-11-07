<?php

namespace myClss;

class App
{
    private static $container;

    public static function setContainer($container): void
    {
        static::$container = $container;
    }
    public static function getContainer()
    {
        return static::$container;
    }

    public static function get($service)
    {
        return static::getContainer()->getService($service);
    }
}