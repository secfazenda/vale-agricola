<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitcf967d6df2bd7fa8d9a9ad484089f45d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitcf967d6df2bd7fa8d9a9ad484089f45d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitcf967d6df2bd7fa8d9a9ad484089f45d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitcf967d6df2bd7fa8d9a9ad484089f45d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
