<?php namespace Modules\Blog;

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class Module
{
    public function registerAutoloaders()
    {

        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces(array(
            "Modules\Blog\Http\Controllers" => '../Modules/Blog/Http/Controllers/',
            "Modules\Blog\Models" => '../Modules/Blog/Models/',
        ));

        $loader->register();
    }

    /**
     * Register the services here to make them module-specific
     */
    public function registerServices($di)
    {
        //Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setDefaultNamespace("Modules\Blog\Http\Controllers\\");
            return $dispatcher;
        });

    }
}
