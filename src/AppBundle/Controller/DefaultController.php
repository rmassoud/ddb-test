<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {


//        dump($this->get("atlas_api_client")->getRegions());
//        dump($this->get("atlas_api_client")->getAreas());
//        die;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'regions' => $this->get("atlas_api_client")->getRegions(),
            'areas' => $this->get("atlas_api_client")->getAreas(),
        ]);
    }

    public function getRegionsAction(Request $request)
    {
        return new JsonResponse($this->get("atlas_api_client")->getRegions());
    }

    public function getAreasAction(Request $request)
    {
        return new JsonResponse($this->get("atlas_api_client")->getAreas());
    }

    public function searchAction(Request $request)
    {
        $region = $request->get('rg', null);
        $area = $request->get('ar', null);
        $page = (int) $request->get('page', 1);

        return new JsonResponse($this->get("atlas_api_client")->search($region, $area, $page));
    }
}
