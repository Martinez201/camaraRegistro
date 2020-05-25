<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Usuarios;
use AppBundle\Form\Model\CambioClave;
use AppBundle\Form\Type\CambioClaveType;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Repository\UsuariosRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("is_granted('ROLE_ADMINISTRADOR')")
 */


class UsuariosController extends Controller
{

    /**
     * @Route("/usuarios/{page}", name="usuarios_listar")
     */
    public function usuariosAction(UsuariosRepository $usuariosRepository,$page = 1){

        $usuarios = $usuariosRepository->obtenerEmpleadosUsuariosOrdenadosQueryBuilder();
        $adaptador = new DoctrineORMAdapter($usuarios,false);
        $pager = new Pagerfanta($adaptador);

        try {

            $pager
                ->setMaxPerPage(10)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }


        return $this->render('usuarios/listar.html.twig',[

            'usuarios' => $usuarios,
            'paginador' => $pager

        ]);

    }

    /**
     * @Route("/usuario/alta", name="usuario_altas", methods={"GET","POST"})
     */
    public function nuevaAction(Request $request, UserPasswordEncoderInterface $encoder){

        $usuario = new Usuarios();
        $this->getDoctrine()->getManager()->persist($usuario);
        return $this->formAction($request,$usuario,$encoder);

    }


    /**
     * @Route("/usuario/{id}", name="usuario_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Usuarios $usuarios, UserPasswordEncoderInterface $encoder){

        $form = $this->createForm(UsuarioType::class, $usuarios);
        $form->handleRequest($request);

        $clave = $form->get('clave')->getData();

        if($clave){

            $usuarios->setClave($encoder->encodePassword($usuarios,$clave));

        }

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
     * @Route("/usuario/eliminar/{id}", name="usuario_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
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


    /**
     * @Route("/uduario/clave/{id}", name="admin_cambiar_clave")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function establecerAction(Request $request, UserPasswordEncoderInterface $encoder, Usuarios $usuarios){

        $cambioCLave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioCLave,[

            'es_admin'=> true
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $usuarios->setClave(

                    $encoder->encodePassword($usuarios, $cambioCLave->getNuevaClave())

                );
                $em->flush();
                $this->addFlash('success','Se ha cambiado la contraseña con éxito');
                $this->redirectToRoute('empleados_form',['id'=> $usuarios->getId()]);

            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se ha podido cambiar la contraseña');

            }

        }

        return $this->render('empleados/establecerClave.html.twig',[

            'formulario'=> $form->createView(),
            'empleado'=> $usuarios

        ]);
    }
}