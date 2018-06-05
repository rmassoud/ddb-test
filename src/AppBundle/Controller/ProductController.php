<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function viewAction(Request $request, $id)
    {
        $product = $this->get("atlas_api_client")->getProduct($id);

//        dump($product); die;

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

}