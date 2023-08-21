<?php

namespace App\Repository;

use App\Entity\GuestBookEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GuestBookRepository extends ServiceEntityRepository
{
    public function __construct(private readonly ManagerRegistry $registry){
        parent::__construct($this->registry, GuestBookEntity::class);
    }

    public function add(GuestBookEntity $guestBookEntity){
        $manager = $this->getEntityManager();
        $manager->persist($guestBookEntity);
    }

    public function flush(){
        $this->getEntityManager()->flush();
    }

    public function getPaginatedEntries(int $limit, int $page):array {
        $offset = ($page - 1) *$limit;
        return $this->findBy([],['createdAt'=>'DESC'],$limit,$offset);
    }

}
