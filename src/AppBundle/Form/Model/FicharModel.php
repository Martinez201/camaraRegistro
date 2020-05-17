<?php

namespace AppBundle\Form\Model;

class FicharModel
{
    /**
     * @var string
     */
    private $dni;

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     * @return FicharModel
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }


}