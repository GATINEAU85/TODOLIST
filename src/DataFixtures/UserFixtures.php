<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const ROLES = 'ROLE_ADMIN';
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $em)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $passwordAdmin = $this->encoder->encodePassword($admin, 'admin');
        $admin->setPassword($passwordAdmin);
        $admin->setRoles(['ROLE_ADMIN']);
        $this->addReference("admin", $admin);
        $em->persist($admin);
        
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@gmail.com');
        $password = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $this->addReference("user", $user);
        $em->persist($user);
        
        $em->flush();
    }
}