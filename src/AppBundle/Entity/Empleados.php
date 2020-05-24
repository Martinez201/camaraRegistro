<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Usuarios;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="empleados")
 */
class Empleados
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 6)
     * @var string
     */
    private $nombre;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 6)
     * @var string
     */
    private $apellidos;
    /**
     * @ORM\Column(type="string", unique= true)
     * @Assert\NotBlank()
     * @Assert\Length(min = 9, max= 10)
     * @var string
     */
    private $dni;
    /**
     * @ORM\Column(type="string" , unique= true)
     * @Assert\NotBlank()
     * @Assert\Length(min = 6)
     * @var string
     */
    private $email;
////////////////////////////////////////////////////////////

    /**
     * @ORM\OneToMany(targetEntity="Accesos",mappedBy="empleado")
     * @var Accesos
     */
    private $accesos;

    /**
     * @ORM\OneToOne(targetEntity="Usuarios",mappedBy="empleado")
     * @var Usuarios
     */
    private $usuario;


////////////////////////////////////////////////////////////////////////
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Empleados
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     * @return Empleados
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     * @return Empleados
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Empleados
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Accesos
     */
    public function getAccesos()
    {
        return $this->accesos;
    }

    /**
     * @param Accesos $accesos
     * @return Empleados
     */
    public function setAccesos($accesos)
    {
        $this->accesos = $accesos;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param \AppBundle\Entity\Usuarios $usuario
     * @return Empleados
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function __toString()
    {
       return $this->getNombre()." ".$this->getApellidos();
    }


}