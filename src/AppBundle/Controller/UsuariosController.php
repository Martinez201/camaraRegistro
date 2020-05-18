<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Usuarios;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/usuarios/alta", name="usuario_altas", methods={"GET","POST"})
     */
    public function nuevaAction(Request $request){

        $usuario = new Usuarios();
        $this->getDoctrine()->getManager()->persist($usuario);
        return $this->formAction($request,$usuario);

    }


    /**
     * @Route("/usuarios/{id}", name="usuario_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Usuarios $usuarios){

        $form = $this->createForm(UsuarioType::class, $usuarios);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Los cambios han sido guardados con éxito');
                return $this->redirectToRoute('usuarios_listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se a podido guardar los cambios');
            }

        }

        return $this->render('usuarios/form.html.twig',[

            'form' => $form->createView(),
            'usuarios'=> $usuarios
        ]);

    }

    /**
     * @Route("/usuarios/eliminar/{id}", name="usuario_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Usuarios $usuarios){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($usuarios);
                $cli->flush();
                $this->addFlash('success','Los cambios han sido guardados con éxito');
                return $this->redirectToRoute('usuarios_listar');

            }catch (\Exception $ex){

            }
            $this->addFlash('error','Error: No se a podido guardar los cambios');
        }

        return $this->render('usuarios/eliminar.html.twig',[

            'usuarios' => $usuarios

        ]);

    }
}