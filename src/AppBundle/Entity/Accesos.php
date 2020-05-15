<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="accesos")
 */
class Accesos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fecha;
    /**
     * @ORM\Column(type="datetime" ,nullable= true)
     * @var \DateTime
     */
    private $horaEntrada;
    /**
     * @ORM\Column(type="datetime" ,nullable= true)
     * @var \DateTime
     */
    private $horaSalida;
    /**
     * @ORM\Column(type="datetime" ,nullable= true)
     * @var \DateTime
     */
    private $horaEntradaTarde;
    /**
     * @ORM\Column(type="datetime" ,nullable= true)
     * @var \DateTime
     */
    private $horaSalidaTarde;


    /**
     * @ORM\ManyToOne(targetEntity="Empleados", inversedBy="accesos")
     * @var Empleados
     */
    private $empleado;



    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return accesos
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }

    /**
     * @param \DateTime $horaEntrada
     * @return accesos
     */
    public function setHoraEntrada($horaEntrada)
    {
        $this->horaEntrada = $horaEntrada;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    /**
     * @param \DateTime $horaSalida
     * @return accesos
     */
    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHoraEntradaTarde()
    {
        return $this->horaEntradaTarde;
    }

    /**
     * @param \DateTime $horaEntradaTarde
     * @return accesos
     */
    public function setHoraEntradaTarde($horaEntradaTarde)
    {
        $this->horaEntradaTarde = $horaEntradaTarde;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHoraSalidaTarde()
    {
        return $this->horaSalidaTarde;
    }

    /**
     * @param \DateTime $horaSalidaTarde
     * @return accesos
     */
    public function setHoraSalidaTarde($horaSalidaTarde)
    {
        $this->horaSalidaTarde = $horaSalidaTarde;
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
     * @return Empleados
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param Empleados $empleado
     * @return Accesos
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }





}