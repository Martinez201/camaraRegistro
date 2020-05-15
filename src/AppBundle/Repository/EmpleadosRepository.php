<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Empleados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class EmpleadosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleados::class);
    }

    public function obtenerEmpleadosOrdenados(){

        return $this->createQueryBuilder('em')
            ->orderBy('em.nombre')
            ->addOrderBy('em.apellidos')
            ->getQuery()
            ->getResult();
    }


}