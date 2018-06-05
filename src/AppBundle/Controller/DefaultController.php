<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'regions' => $this->get("atlas_api_client")->getRegions(),
            'areas' => $this->get("atlas_api_client")->getAreas(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getRegionsAction(Request $request)
    {
        return new JsonResponse($this->get("atlas_api_client")->getRegions());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAreasAction(Request $request)
    {
        return new JsonResponse($this->get("atlas_api_client")->getAreas());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $region = $request->get('rg', null);
        $area = $request->get('ar', null);
        $page = (int) $request->get('page', 1);

        return new JsonResponse($this->get("atlas_api_client")->search($region, $area, $page));
    }
}
