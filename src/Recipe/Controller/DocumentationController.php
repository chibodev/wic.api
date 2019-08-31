<?php

declare(strict_types=1);


namespace App\Recipe\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/documentation")
 */
class DocumentationController extends AbstractController
{
    /**
     * @Route("/api", name="api_documentation")
     * @throws Exception
     */
    public function documentation(): Response
    {
        return new Response(file_get_contents(__DIR__. '/../../../templates/docs/api.html'));
    }
}
