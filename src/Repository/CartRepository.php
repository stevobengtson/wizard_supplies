<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CartRepository extends ServiceEntityRepository {
  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Cart::class);
  }

  public function pageCarts($page = 1, $limit = 10) {
    $query = $this->createQueryBuilder('c')
                  ->getQuery();

    return $this->paginate($query, $page, $limit);
  }

  public function paginate($query, $page = 1, $limit = 10) {
    $paginator = new Paginator($query);
    $paginator->getQuery()
              ->setFirstResult($limit * ($page - 1))
              ->setMaxResults($limit);

    return $paginator;
  }
}
?>
