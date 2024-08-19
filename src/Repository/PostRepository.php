<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    // Selection partielle de l'entité post
    public function filterBytitle($title): array
    {
        return $this->createQueryBuilder("p")
            ->andWhere("p.title = :title")
            ->setParameter("title", $title)
            ->getQuery()
            ->getResult();
    }

    public function filterbyParams(?string $title, ?string $category): array
    {
        $qb = $this->createQueryBuilder("q");

        if ($title) {
            $qb->andWhere("q.title = :title")
                ->setParameter("title", $title);
        }

        if ($category) {
            // Ajout d'une jointure pour filtrer par catégorie
            $qb->innerJoin('q.categories', 'c')
                ->andWhere("c.name = :category")
                ->setParameter("category", $category);
        }

        // Retourner tous les résultats correspondant aux critères
        return $qb->getQuery()->getResult();
    }

    public function filterByDate($date)
    {
        return $this->createQueryBuilder("q")
            ->andWhere("q.created_at <= :date")
            ->setParameter("date", $date)
            ->orderBy("q.title", "ASC")
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
