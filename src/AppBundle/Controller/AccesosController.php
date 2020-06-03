<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Accesos;
use AppBundle\Form\Type\FicharType;
use AppBundle\Repository\AccesosRepositoy;
use AppBundle\Repository\EmpleadosRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccesosController extends Controller
{

    /**
     * @Route("/accesos/{page}", name="accesos_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function accesosAction(AccesosRepositoy  $accesosRepositoy,$page = 1){

        $accesos = $accesosRepositoy->obtenerTodosAccesosQueryBuilder();
        $adaptador = new DoctrineORMAdapter($accesos,false);
        $pager = new Pagerfanta($adaptador);

        try {

            $pager
                ->setMaxPerPage(10)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }

        return $this->render('accesos/listar.html.twig',[

            'accesos'=> $accesos,
            'paginador' => $pager

        ]);

    }


    /**
     * @Route("/",name="alta_fichar", methods={"GET","POST"})
     */

    public function formAction(Request $request, AccesosRepositoy $accesosRepositoy, EmpleadosRepository $empleadosRepository){

        $form = $this->createForm(FicharType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $usuario = $empleadosRepository->obtenerEmpleadoDni($form->get('dni')->getData());
            $fecha = date('Y-m-d');


            if($usuario){

                $acceso = $accesosRepositoy->obtenerAcceso($fecha,$usuario);

                if(isset($_POST['mananaEntrada'])){

                    if($acceso == 0){

                        $accesoNuevo = new Accesos();
                        $accesoNuevo->setEmpleado($usuario[0]);
                        $accesoNuevo->setFecha(date_create($fecha));
                        $accesoNuevo->setHoraEntrada(date_create(date('H:i:s')));

                       $em = $this->getDoctrine()->getManager();
                       $em->persist($accesoNuevo);
                       $em->flush();

                       $this->addFlash('success','Entrada registrada con éxito a la hora '.date('H:i:s').' del dia '.date('d-m-Y'));
                    }
                    else{

                        $this->addFlash('error','Error: Ya has fichado la entrada en el turno de mañana');

                    }

                }
                if(isset($_POST['mananaSalida'])){

                    if($usuario){

                        $acceso = $accesosRepositoy->obtenerAcceso($fecha,$usuario);
                        $entrada = $accesosRepositoy->obtenerEntradaManana($fecha,$usuario);

                        if($acceso == 0 || $entrada == 0){

                             $this->addFlash('error','Error: no has fichado la entrada');

                        }else{

                            $hafichado = $accesosRepositoy->obtenerSalida($fecha,$usuario);

                            if($hafichado == 1){

                                $this->addFlash('error','Error: Ya has fichado la salida en el turno de mañana');
                            }
                            else{

                                $resultado = $accesosRepositoy->obtenerTurnoTarde($fecha,$usuario);
                                $resultado->setHoraSalida(date_create(date('H:i:s')));
                                $em = $this->getDoctrine()->getManager();
                                $em->flush();
                                $this->addFlash('success','Salida registrada con éxito a la hora '.date('H:i:s').' del dia '.date('d-m-Y'));
                            }

                        }
                    }

                }
                if(isset($_POST['tardeEntrada'])){

                    if($acceso == 0){


                        $accesoNuevo = new Accesos();
                        $accesoNuevo->setEmpleado($usuario[0]);
                        $accesoNuevo->setFecha(date_create($fecha));
                        $accesoNuevo->setHoraEntradaTarde(date_create(date('H:i:s')));

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($accesoNuevo);
                        $em->flush();

                        $this->addFlash('success','Entrada registrada con éxito');
                    }
                    else{

                        $entradaTarde = $accesosRepositoy->obtenerEntradaTarde($fecha,$usuario);

                        if($entradaTarde == 0){

                            $resultado = $accesosRepositoy->obtenerTurnoTarde($fecha,$usuario);

                                $resultado->setHoraEntradaTarde(date_create(date('H:i:s')));
                                $em = $this->getDoctrine()->getManager();
                                $em->flush();
                                $this->addFlash('success','Entrada registrada con éxito a hora '.date('H:i:s').' del dia '.date('d-m-Y'));
                        }
                        else{

                            $this->addFlash('error','Error: Ya has fichado la entrada en el turno de tarde');
                        }
                    }

                }
                if(isset($_POST['tardeSalida'])){

                    if($usuario){

                        $acceso = $accesosRepositoy->obtenerAcceso($fecha,$usuario);
                        $entrada = $accesosRepositoy->obtenerEntradaTarde($fecha,$usuario);

                        if($acceso == 0 || $entrada == 0){

                            $this->addFlash('error','Error: no has fichado la entrada');

                        }
                        else{

                            $hafichado = $accesosRepositoy->obtenerSalidaTarde($fecha,$usuario);

                            if($hafichado == 1){

                                $this->addFlash('error','Error: Ya has fichado la salida en el turno de tarde');
                            }
                            else{

                                $resultado = $accesosRepositoy->obtenerTurnoTarde($fecha,$usuario);
                                $resultado->setHoraSalidaTarde(date_create(date('H:i:s')));
                                $em = $this->getDoctrine()->getManager();
                                $em->flush();
                                $this->addFlash('success','Salida registrada con éxito a la hora '.date('H:i:s').' del dia '.date('d-m-Y'));
                            }

                        }
                    }

                }
            }
            else{

                $this->addFlash('error','Error: No hay ningún empleado registrado con ese D.N.I');

            }

        }

        return $this->render('accesos/form.html.twig',[

            'form' => $form->createView(),
            'hora' => date('H:i:s')
        ]);
    }



}