<?php


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
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $apellidos;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $telefono;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $administrador;






    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Usuarios
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
     * @return Usuarios
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
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
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     * @return Usuarios
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}