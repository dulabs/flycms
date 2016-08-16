<?php namespace Modules\Catalog;


class Module
{
    public function registerAutoloaders()
    {

        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces(array(
            "Modules\Catalog\Http\Controllers" => '../Modules/Catalog/Http/Controllers/',
            "Modules\Catalog\Models" => '../Modules/Catalog/Models/',
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
            $dispatcher->setDefaultNamespace("Modules\Catalog\Http\Controllers\\");
            return $dispatcher;
        });


        $di->set('db', function () {
            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));
        });
    }
}
