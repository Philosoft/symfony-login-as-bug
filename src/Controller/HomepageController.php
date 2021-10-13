<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController
{
    /** @Route("/", name="app__homepage") */
    public function homepage(): Response
    {
        return new Response('Homepage is working');
    }
}
