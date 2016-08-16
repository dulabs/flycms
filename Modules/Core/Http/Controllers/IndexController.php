<?php namespace Modules\Core\Http\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller {

    public function indexAction()
    {
        echo "Modules";
    }

    public function testAction()
    {
        echo "dana";
    }

    public function notfoundAction()
    {
        echo "Not Found";
    }

}
