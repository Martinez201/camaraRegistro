<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Empleados;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuarios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $administrador;

    /**
     * @ORM\OneToOne(targetEntity="Empleados", inversedBy="usuario")
     * @var Empleados
     */
    private $empleado;


    /**
     * @return bool
     */
    public function isAdministrador()
    {
        return $this->administrador;
    }

    /**
     * @param bool $administrador
     * @return Usuarios
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return \AppBundle\Entity\Empleados
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param \AppBundle\Entity\Empleados $empleado
     * @return Usuarios
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }


}