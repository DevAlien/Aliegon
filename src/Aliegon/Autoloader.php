<?php

class Autoloader
{
    /**
     * Registers Autoloader as an SPL autoloader.
     *
     * @param Boolean $prepend Whether to prepend the autoloader or not.
     */
    public static function register($prepend = false)
    {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(new self, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(new self, 'autoload'));
        }
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'Aliegon')) {
            return;
        }

        if (is_file($file = dirname(__FILE__).'/../'.str_replace('\\', '/', str_replace(array('_', "\0"), array('/', ''), $class).'.php'))) {
            require $file;
        }
    }
}