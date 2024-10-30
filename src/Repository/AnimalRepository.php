<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function findPublishedByPage(array $params, int $maxResult)
    {
        $currentPage = isset($params["p"]) ? intval($params["p"]) : 1;
        $sorting = $params["sorting"] ?? null;
        $filters = $params["filters"] ?? null;

        $q = $this->createQueryBuilder("a")
                    ->select("a")
                    ->leftJoin("a.breed","b")
                    ->addSelect("b")
                    ->leftJoin("b.type","t")
                    ->addSelect("t")
                    ->where("a.is_published = 1");

       if(!empty($filters)){
           if(!empty($filters["type"])){
               $q->andWhere('t.id in (:idType)')
                   ->setParameter('idType',$filters["type"]);
           }

           if(!empty($filters["breed"])){
               $q->andWhere("b.id in (:idBreed)")
                   ->setParameter("idBreed",$filters["breed"]);
           }
       }

       if(($sorting === "ASC" || $sorting === "DESC")){
           $q->orderBy("a.name", $sorting);
       }


        return $q->setFirstResult(($currentPage-1)*$maxResult)
                ->setMaxResults($maxResult)
                ->getQuery()->getResult();


    }

    public function findPublished(array $params)
    {
        $filters = $params["filters"] ?? null;

        $q = $this->createQueryBuilder("a")
            ->select("a")
            ->leftJoin("a.breed","b")
            ->addSelect("b")
            ->leftJoin("b.type","t")
            ->addSelect("t")
            ->where("a.is_published = 1");

        if(!empty($filters)){
            if(!empty($filters["type"])){
                $q->andWhere('t.id in (:idType)')
                    ->setParameter('idType',$filters["type"]);
            }

            if(!empty($filters["breed"])){
                $q->andWhere("b.id in (:idBreed)")
                    ->setParameter("idBreed",$filters["breed"]);
            }
        }

        return $q->getQuery()->getResult();
    }

    public function findByPage(int $currentPage,int $maxResult)
    {
        return $this->createQueryBuilder("a")
                    ->select("a")
                    ->setFirstResult(($currentPage-1)*$maxResult)
                    ->setMaxResults($maxResult)
                    ->orderBy("a.id","DESC")
                    ->getQuery()->getResult();
    }


    //    /**
    //     * @return Animal[] Returns an array of Animal objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Animal
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
