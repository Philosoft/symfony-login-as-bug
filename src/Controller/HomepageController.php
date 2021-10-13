<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /** @Route("/", name="app__homepage") */
    public function homepage(): Response
    {
        return new Response('Homepage is working');
    }

    /** @Route("/test-auth", name="app__test-auth") */
    public function testAuthPage(): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            throw new AccessDeniedHttpException('You cannot do this');
        }

        return new Response("Greetings {$user->getUserIdentifier()}");
    }
}
