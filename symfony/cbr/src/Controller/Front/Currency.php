<?php

declare(strict_types=1);

namespace App\Controller\Front;

//use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation as Rest;
//use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Currency
 * @package App\Controller\Front
 */
class Currency extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function index(): Response
    {
        // ...

        // the `render()` method returns a `Response` object with the
        // contents created by the template
        return $this->render('currency/index.html.twig', [
            'category' => '...',
            'promotions' => ['...', '...'],
        ]);

        // the `renderView()` method only returns the contents created by the
        // template, so you can use those contents later in a `Response` object
//        $contents = $this->renderView('base.html.twig', [
//            'category' => '...',
//            'promotions' => ['...', '...'],
//        ]);
//
//        return new Response($contents);
    }
}
