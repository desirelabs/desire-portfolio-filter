<?php

/**
 * Autoload classes
 * @author franck LEBAS
 * @package desire-portfolio-filter
 */
spl_autoload_register(function ($class) {
    $classFile = dirname(__FILE__) . '/src/' . $class . '.php';
    try {
        // Check if class file exists
        if (file_exists($classFile))
            include 'src/' . $class . '.php';
    } catch (Exception $e) {
        echo 'Classes not loaded : ' . $e->getMessage();
    }
});
