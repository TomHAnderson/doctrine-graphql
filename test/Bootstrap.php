<?php

namespace ApiSkeletonsTest\Doctrine\GraphQL;

use Laminas\Loader\AutoloaderFactory;
use RuntimeException;

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    public static function init()
    {
        static::initAutoloader();
        include __DIR__ . '/start.php';
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        if (! class_exists('Laminas\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load Laminas. Run `php composer.phar install`'
            );
        }

        AutoloaderFactory::factory([
            'Laminas\Loader\StandardAutoloader' => [
                'autoregister_zf' => true,
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ]);
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (! is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}
