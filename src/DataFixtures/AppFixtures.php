<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //create 20 users with password 

        UserFactory::createMany(20);

        //create comments
        CommentFactory::createMany(20);
        
        //create a categroy
        CategoryFactory::createMany(5);

        

        //create post
        PostFactory::createMany(20);


        $manager->flush();
    }
}
