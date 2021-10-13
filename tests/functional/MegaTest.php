<?php

declare(strict_types=1);

namespace App\Tests\functional;

use App\Security\UserProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MegaTest extends WebTestCase
{
    public function testHomepage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testAnon(): void
    {
        $client = static::createClient();
        $client->request('GET', '/test-auth');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $userProvider = new UserProvider();
        $userFoo = $userProvider->loadUserByIdentifier('foo@example.com');
        $client->loginUser($userFoo);

        $client->request('GET', '/test-auth');

        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith($userFoo->getUserIdentifier(), $client->getResponse()->getContent());
    }

    public function testMultiLogin(): void
    {
        $client = static::createClient();
        $userProvider = new UserProvider();
        $userFoo = $userProvider->loadUserByIdentifier('foo@example.com');
        $userBar = $userProvider->loadUserByIdentifier('bar@example.com');
        $client->loginUser($userFoo);

        $client->request('GET', '/test-auth');

        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith($userFoo->getUserIdentifier(), $client->getResponse()->getContent());

        $client->loginUser($userBar);
        $client->request('GET', '/test-auth');
        $this->assertResponseIsSuccessful();
        $this->assertStringEndsWith($userBar->getUserIdentifier(), $client->getResponse()->getContent());
    }
}
