<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function search(array $params)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.location', 'l')
            ->groupBy('p.id');

        if (isset($params["filter-location"]) && $location = $params["filter-location"]) {
            $qb
                ->andWhere('l.name = :location')
                ->setParameter('location', $location);
        }

        if (isset($params["filter-property-type"]) && $category = $params["filter-property-type"]) {
            $qb
                ->andWhere('c.name = :category')
                ->setParameter('category', $category);
        }

        if (isset($params["filter-price-from"]) && $fromPrice = $params["filter-price-from"]) {
            $qb
                ->andWhere('p.price >= :fromPrice')
                ->setParameter('fromPrice', $fromPrice);
        }

        if (isset($params["filter-price-to"]) && $toPrice = $params["filter-price-to"]) {
            $qb
                ->andWhere('p.price <= :toPrice')
                ->setParameter('toPrice', $toPrice);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByCategories(array $categories, int $limit = null)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->leftJoin('p.category', 'c')
            ->where($qb->expr()->in('c.name', ':categories'))
            ->setParameter('categories', $categories, Connection::PARAM_STR_ARRAY)
            ->orderBy('p.id', 'DESC')
            ->groupBy('p.id');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
