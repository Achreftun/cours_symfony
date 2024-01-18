<?php

namespace App\Repository;

use PDO;
use App\Entity\Adresse;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Adresse>
 *
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    //    /**
//     * @return Adresse[] Returns an array of Adresse objects
//     */
    public function findByValue($value)
    {
        // SQL
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT id, rue, ville, code_postal as codePostal
            FROM adresse
            WHERE rue LIKE :value
            or ville LIKE :value
            or code_postal LIKE :value
            '
        )
            ->executeQuery(['value' => '%' . $value . '%'])
            ->fetchAllAssociative();

        // DQL
        // return $this->getEntityManager()->createQuery(
        //     'SELECT a
        //     FROM App\Entity\Adresse a
        //     WHERE a.rue LIKE :value
        //     or a.ville LIKE :value
        //     or a.codePostal LIKE :value'
        // )
        //     ->setParameter('value', '%' . $value . '%')
        //     ->getResult();

        // Query Builder
        // return $this->createQueryBuilder('a')
        //     ->where('a.rue LIKE :val')
        //     ->setParameter('val', '%' . $value . '%')
        //     ->orWhere('a.ville LIKE :val')
        //     ->setParameter('val', '%' . $value . '%')
        //     ->orWhere('a.codePostal LIKE :val')
        //     ->setParameter('val', '%' . $value . '%')
        //     ->getQuery()
        //     ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Adresse
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
