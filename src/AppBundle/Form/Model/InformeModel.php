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


}