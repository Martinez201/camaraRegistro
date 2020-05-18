<?php


namespace AppBundle\Controller;


use AppBundle\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UsuariosController extends Controller
{

    /**
     * @Route("/usuarios", name="usuarios_listar")
     */
    public function usuariosAction(UsuariosRepository $usuariosRepository){

        $usuarios = $usuariosRepository->obtenerEmpleadosUsuariosOrdenados();

        return $this->render('usuarios/listar.html.twig',[

            'usuarios' => $usuarios

        ]);

    }

}