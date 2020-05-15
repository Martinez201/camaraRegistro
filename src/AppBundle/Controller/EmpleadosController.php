<?php


namespace AppBundle\Controller;


use AppBundle\Repository\EmpleadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EmpleadosController extends Controller
{

    /**
     * @Route("/empleados", name="empleados_listar")
     */

    public function empleadosAction(EmpleadosRepository $empleadosRepository){

        $empleados = $empleadosRepository->obtenerEmpleadosOrdenados();

        return $this->render('empleados/listar.html.twig',[

            'empleados'=> $empleados
        ]);

    }

}