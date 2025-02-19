<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testInitialState(): void
    {
        $this->assertNull($this->user->getId());
        $this->assertNull($this->user->getEmail());
        // Le rôle ROLE_USER est toujours présent par défaut
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    public function testEmailMutator(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);
        $this->assertEquals($email, $this->user->getEmail());
    }

    public function testCustomRole(): void
    {
        $this->user->setRoles(['ROLE_ADMIN']);
        $roles = $this->user->getRoles();
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles); // ROLE_USER est toujours présent
    }
}