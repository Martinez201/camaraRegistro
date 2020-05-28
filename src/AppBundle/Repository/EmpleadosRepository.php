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

    public function obtenerEmpleadosOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('em')
            ->orderBy('em.nombre')
            ->addOrderBy('em.apellidos');

    }

    public function obtenerEmpleadosOrdenados(){

        return $this->obtenerEmpleadosOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerEmpleadoDni($dni){

        return $this->createQueryBuilder('e')
            ->where('e.dni = :dni')
            ->setParameter('dni',$dni)
            ->getQuery()
            ->getResult();
    }

    public function obtenerEmpleadoApellidos($buscar){

        return $this->createQueryBuilder('e')
            ->where('e.id = :buscar')
            ->setParameter('buscar',$buscar)
            ->getQuery()
            ->getResult();
    }



}