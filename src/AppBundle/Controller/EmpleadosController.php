<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleados;
use AppBundle\Form\Type\EmpleadoType;
use AppBundle\Repository\EmpleadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/empleados/alta", name="empleados_altas", methods={"GET","POST"})
     */
    public function nuevaAction(Request $request){

        $empleado = new Empleados();
        $this->getDoctrine()->getManager()->persist($empleado);
        return $this->formAction($request,$empleado);

    }


    /**
     * @Route("/empleados/{id}", name="empleados_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Empleados $empleados){

        $form = $this->createForm(EmpleadoType::class, $empleados);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Los cambios han sido guardados con éxito');
                return $this->redirectToRoute('empleados_listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se a podido guardar los cambios');
            }

        }

        return $this->render('empleados/form.html.twig',[

            'form' => $form->createView(),
            'empleado'=> $empleados
        ]);

    }

    /**
     * @Route("/empleados/eliminar/{id}", name="empleados_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Empleados $empleados){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($empleados);
                $cli->flush();
                $this->addFlash('success','Los cambios han sido guardados con éxito');
                return $this->redirectToRoute('empleados_listar');

            }catch (\Exception $ex){

            }
            $this->addFlash('error','Error: No se a podido guardar los cambios');
        }

        return $this->render('empleados/eliminar.html.twig',[

            'empleados' => $empleados

        ]);

    }

}