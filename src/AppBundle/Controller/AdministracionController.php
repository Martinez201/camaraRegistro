<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdministracionController extends Controller
{

    /**
     * @Route("/administracion", name="administracion_menu")
     */

    public function menuAdministracion(){

        return $this->render('administracion/menu.html.twig');

    }

}