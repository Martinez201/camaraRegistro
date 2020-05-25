<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Usuarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UsuariosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuarios::class);
    }

    public function obtenerEmpleadosUsuariosOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('us')
            ->orderBy('us.empleado');



    }

    public function obtenerEmpleadosUsuariosOrdenados(){

        return $this->obtenerEmpleadosUsuariosOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }


}