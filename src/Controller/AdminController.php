<?php

namespace Dameert\FrontendCms\Controller;


use Dameert\FrontendCms\Data\FrontendUpdate;
use Dameert\FrontendCms\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/frontend")
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="fe_admin")
     */
    public function adminAction(Request $request)
    {
        $this->denyAccessUnlessGranted(User::ROLE_FRONTEND_ADMIN);
        return $this->render('@DameertFrontendCms/admin/index.html.twig');
    }

    /**
     * @Route("/save", name="fe_save")
     */
    public function saveAction(Request $request)
    {
        $this->denyAccessUnlessGranted(User::ROLE_FRONTEND_ADMIN);

        $data = $request->request->get('modifications');
        $type = $request->request->get('type');

        $update = new FrontendUpdate($data, $type);
        dump($update->getJson());
        return $this->json('done');
    }
}