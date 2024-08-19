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

        // UserFactory::createMany(5);

        // //create comments
        // CommentFactory::createMany(2);

        // //create a categroy
        CategoryFactory::createMany(2);



        // //create post
        PostFactory::createMany(10);


        $manager->flush();
        // $manager->clear();

        //  // Création des entités par lots
        //  foreach (range(1, 10) as $i) {
        //     UserFactory::createMany(10);
        //     CommentFactory::createMany(3);
        //     CategoryFactory::createMany(5);
        //     PostFactory::createMany(20);

        //     $manager->flush();
        //     // $manager->clear(); // Libère la mémoire utilisée par les objets persistés
        // }
    }
}
