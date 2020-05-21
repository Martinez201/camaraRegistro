<?php


namespace AppBundle\Form\Model;


class CambioClave
{
    /**
     * @var string
     */
    private $claveAntigua;


    /**
     * @var string
     */
    private $nuevaClave;

    /**
     * @return string
     */
    public function getClaveAntigua()
    {
        return $this->claveAntigua;
    }

    /**
     * @param string $claveAntigua
     * @return CambioClave
     */
    public function setClaveAntigua($claveAntigua)
    {
        $this->claveAntigua = $claveAntigua;
        return $this;
    }

    /**
     * @return string
     */
    public function getNuevaClave()
    {
        return $this->nuevaClave;
    }

    /**
     * @param string $nuevaClave
     * @return CambioClave
     */
    public function setNuevaClave($nuevaClave)
    {
        $this->nuevaClave = $nuevaClave;
        return $this;
    }

}