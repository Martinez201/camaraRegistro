<?php


namespace AppBundle\Form\Model;


class InformeModel
{
    /**
     * @var \DateTime
     */
    private $fechaPrincipio;
    /**
     * @var \DateTime
     */
    private $fechaFinal;

    /**
     * @var string
     */
    private $empleado;

    /**
     * @return \DateTime
     */
    public function getFechaPrincipio()
    {
        return $this->fechaPrincipio;
    }

    /**
     * @param \DateTime $fechaPrincipio
     * @return InformeModel
     */
    public function setFechaPrincipio($fechaPrincipio)
    {
        $this->fechaPrincipio = $fechaPrincipio;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * @param \DateTime $fechaFinal
     * @return InformeModel
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param string $empleado
     * @return InformeModel
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }


}