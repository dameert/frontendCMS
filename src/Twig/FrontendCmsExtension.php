<?php

namespace Dameert\FrontendCms\Twig;

use Dameert\FrontendCms\Entity\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class FrontendCmsExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @param Router $router
     */
    public function __construct(Router $router, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'frontendEditorAttributes',
                array($this, 'frontendEditorAttributes'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Generate all attributes needed for the Javascript Editor
     * @param string $type
     * @return string
     */
    public function frontendEditorAttributes($type)
    {
        if (!$this->authorizationChecker->isGranted(User::ROLE_FRONTEND_ADMIN)) {
            return "";
        }

        return $this->ajaxType($type) . $this->ajaxSavePath();
    }

    /**
     * Generate the current page type
     * @param string $type
     * @return string
     */
    private function ajaxType($type)
    {
        return ' data-frontend-editor-type="' . $type . '"';
    }

    /**
     * Generate the url to send the page content via ajax
     * @return string
     */
    private function ajaxSavePath()
    {
        return ' data-frontend-editor-url="' . $this->router->generate('fe_save') . '"';
    }
}