<?php namespace Modules\Catalog\Http\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller {

    public function indexAction()
    {

        $product['name'] = "Choki-choki";
        $product['price'] = 500;

        $products[] = $product;

        $this->response->setContent(json_encode($products));

        return $this->response;
    }

}
