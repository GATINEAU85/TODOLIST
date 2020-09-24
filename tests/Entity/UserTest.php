<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testUsername(): void
    {
        $this->user->setUsername('name');
        $this->assertSame('name', $this->user->getUsername());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('password');
        $this->assertSame('password', $this->user->getPassword());
    }

    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

    public function testEmail(): void
    {
        $this->user->setEmail('name@name.fr');
        $this->assertSame('name@name.fr', $this->user->getEmail());
    }

    public function testRoles(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }
}
