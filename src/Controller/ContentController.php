<?php

namespace Dameert\FrontendCms\Controller;

use Dameert\FrontendCms\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends Controller
{
    /**
     * @Route("", name="frontend_home")
     */
    public function indexAction(ContentService $contentService)
    {
        return $this->renderContent($contentService, 'index');
    }

    /**
     * @Route("/{name}", name="frontend_content")
     */
    public function contentAction(ContentService $contentService, $name)
    {
        return $this->renderContent($contentService, $name);
    }

    /**
     * @param ContentService $contentService
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderContent(ContentService $contentService, $name)
    {
        $data = $contentService->getJsonContent("$name.json");
        $template = $contentService->getTemplatePath(
            strtolower($data->getType()) . '.html.twig'
        );

        return $this->render($template, [
            'data' => $data->getData(),
            'type' => $data->getType(),
        ]);
    }
}