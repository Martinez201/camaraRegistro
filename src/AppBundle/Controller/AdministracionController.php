<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 */

class AdministracionController extends Controller
{

    /**
     * @Route("/administracion", name="administracion_menu")
     */

    public function menuAdministracion(){

        return $this->render('administracion/menu.html.twig');

    }

    /**
     * @Route("/administracion/informes", name="informes_menu")
     */

    public function menuInformes(){

        return $this->render('administracion/menuInformes.html.twig');

    }

}