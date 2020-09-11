<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $task1 = new Task();
        $task1->setTitle("First task to do");
        $task1->setContent("Content of this first task.");
        $task1->toggle(!$task1->isDone());        
        //$task1->setCreateAt(date("Y-m-d H:i:s"));
        $task1->setUser($em->getRepository(User::class)->find(1));
        $em->persist($task1);
        
        $task2 = new Task();
        $task2->setTitle("Second task to do");
        $task2->setContent("Content of this second task.");
        //$task2->setCreateAt(date("Y-m-d H:i:s"));
        $task2->setUser($em->getRepository(User::class)->find(2));
        $em->persist($task2);
        
        $task3 = new Task();
        $task3->setTitle("Third task to do");
        $task3->setContent("Content of this third task.");
        $task3->toggle(!$task3->isDone());        
        //$task3->setCreateAt(date("Y-m-d H:i:s"));
        $task3->setUser($em->getRepository(User::class)->find(1));
        $em->persist($task3);
        
        $em->flush();
    }
    
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}