<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Config\Adapter\Ini as ConfigIni;

require_once __DIR__."/../vendor/autoload.php";

define('ROOT_PATH',str_replace("bootstrap","",__DIR__));

// init DI
$di = new FactoryDefault();

// get Module Config
$moduleConfig = new ConfigIni("../config/module.ini");

// load Modules
$modular = new Dulabs\Modular\Modular();
$module  = $modular
            ->setDirectory($moduleConfig->module->moduleDir)
            ->load();

// Registering router
$router = new Router();
$router->setDefaultModule('core');
$module->setRouter($router);
$di->set('router',$router);


// Register Volt as a service
$di->setShared(
    'voltService',
    function ($view, $di) {

        $volt = new Volt($view, $di);

        $volt->setOptions(
            array(
                "compiledPath"      => "../storage/views/",
                "compiledExtension" => ".compiled",
                "compiledSeparator" => "_"
            )
        );

        return $volt;
    }
);

//Registering a shared view component
$di->setShared('view', function() {
    $view = new View();
    $view->setViewsDir('resources/views/');
    $view->setLayoutsDir('layouts/');
    $view->registerEngines(
            array(
                ".volt" => 'voltService'
                )
            );
    return $view;
});


$application = new Application($di);

$activeModules = $module->getModules();

$application->registerModules($activeModules);

return $application;
