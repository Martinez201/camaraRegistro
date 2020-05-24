<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Empleados;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuarios implements UserInterface
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
     * @ORM\Column(type="string", unique= true)
     * @var string
     */
    private $nombreUsuario;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $clave;

    ///////////////////////////////////////

    /**
     * @ORM\OneToOne(targetEntity="Empleados", inversedBy="usuario")
     * @var Empleados
     */
    private $empleado;

////////////////////////////////////////////////////

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

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param string $nombreUsuario
     * @return Usuarios
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     * @return Usuarios
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    public function getRoles()
    {
        $roles = ['ROLE_USER'];

        if($this->isAdministrador()){

            $roles[] = 'ROLE_ADMINISTRADOR';
        }
        else{

            $roles[] = 'ROLE_USUARIO';
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->getClave();
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getNombreUsuario();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


}