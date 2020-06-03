<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Accesos;
use AppBundle\Entity\Empleados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AccesosRepositoy extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accesos::class);
    }

    public function obtenerTodosAccesosQueryBuilder(){

        return $this->createQueryBuilder('ac')
            ->orderBy('ac.fecha');


    }
    public function obtenerTodosAccesos(){

        return $this->obtenerTodosAccesosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerAcceso($fecha,$empleado){

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->Where('a.fecha = :fecha')
            ->andWhere('a.empleado = :empleado')
            ->setParameter('empleado', $empleado)
            ->setParameter('fecha',$fecha)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function obtenerEntradaTarde($fecha,$empleado){

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->Where('a.fecha = :fecha')
            ->andWhere('a.empleado = :empleado')
            ->andWhere('a.horaEntradaTarde IS NOT NULL ')
            ->setParameter('empleado', $empleado)
            ->setParameter('fecha',$fecha)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function obtenerEntradaManana($fecha,$empleado){

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->Where('a.fecha = :fecha')
            ->andWhere('a.empleado = :empleado')
            ->andWhere('a.horaEntrada IS NOT NULL ')
            ->setParameter('empleado', $empleado)
            ->setParameter('fecha',$fecha)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function obtenerTurnoTarde($fecha,$empleado){

         return $this->createQueryBuilder('a')
             ->Where('a.fecha = :fecha')
             ->andWhere('a.empleado = :empleado')
             ->setParameter('empleado', $empleado)
             ->setParameter('fecha',$fecha)
             ->getQuery()
             ->getSingleResult();


    }

    public function obtenerSalida($fecha,$empleado){

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->Where('a.fecha = :fecha')
            ->andWhere('a.empleado = :empleado')
            ->setParameter('empleado', $empleado)
            ->setParameter('fecha',$fecha)
            ->andWhere('a.horaSalida IS NOT NULL ')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function obtenerSalidaTarde($fecha,$empleado){

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->Where('a.fecha = :fecha')
            ->andWhere('a.empleado = :empleado')
            ->setParameter('empleado', $empleado)
            ->setParameter('fecha',$fecha)
            ->andWhere('a.horaSalidaTarde IS NOT NULL ')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function obtenerAccesosPorFechas($inicio, $fin){

        return $this->createQueryBuilder('a')
            ->where('a.fecha BETWEEN :inicio AND :fin')
            ->setParameter('inicio', $inicio)
            ->setParameter('fin', $fin)
            ->getQuery()
            ->getResult();


    }

    public function obtenerAccesosFechasApellidos($inicio, $fin,$empleado){

        return $this->createQueryBuilder('a')
            ->where('a.fecha BETWEEN :inicio AND :fin')
            ->andWhere('a.empleado = :empleado')
            ->setParameter('inicio', $inicio)
            ->setParameter('fin', $fin)
            ->setParameter('empleado',$empleado)
            ->getQuery()
            ->getResult();
    }

}