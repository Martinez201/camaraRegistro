<?php


namespace AppBundle\Controller;


use AppBundle\Form\Type\InformeType;
use AppBundle\Repository\AccesosRepositoy;
use AppBundle\Repository\EmpleadosRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;
/**
 * @Security("is_granted('ROLE_USER')")
 */

class FicherosInformesController extends Controller
{

    /**
     * @Route("/informe/excel",name="informe_excel", methods={"GET", "POST"})
     */

      public function excelAction(Request $request, AccesosRepositoy $accesosRepositoy, EmpleadosRepository $empleadosRepository)
      {

          $form = $this->createForm(InformeType::class);
          $form->handleRequest($request);
          $accesos = 0;
          if ($form->isSubmitted() && $form->isValid()) {

              $fechaInicial = $form->get('fechaPrincipio')->getData();
              $fechaFinal = $form->get('fechaFinal')->getData();
              $buscar = $form->get('empleado')->getData();

              if(!$buscar){

                  $accesos = $accesosRepositoy->obtenerAccesosPorFechas($fechaInicial, $fechaFinal);

              }
              else{

                  $empleado = $empleadosRepository->obtenerEmpleadoApellidos($buscar);

                  if(!$empleado){

                      $this->addFlash('error','Error: No se ha encotrado ningún empleado con ese dni');
                  }
                  else{

                      $accesos = $accesosRepositoy->obtenerAccesosFechasApellidos($fechaInicial, $fechaFinal,$empleado[0]->getId());
                  }

              }

                if(!$accesos){

                    $this->addFlash('error','Error: No se ha encontrado ningún acceso');

                }
                else{
                    $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

                    $phpExcelObject->getProperties()->setCreator('Camara Linares')
                        ->setTitle('informe');

                    $excel = $phpExcelObject->setActiveSheetIndex(0);

                    $excel->setCellValue('D7', 'Empleado');
                    $excel->setCellValue('E7', 'Fecha');
                    $excel->setCellValue('F7', 'Entrada (Mañana)');
                    $excel->setCellValue('G7', 'Salida (Mañana)');
                    $excel->setCellValue('H7', 'Entrada (Tarde)');
                    $excel->setCellValue('I7', 'Salida (Tarde)');
                    $excel->setCellValue('J7', 'Total(horas)');

                    $filas = 8;


                    foreach ($accesos as $dato) {

                        $excel->setCellValue('D' . $filas, $dato->getEmpleado());
                        $excel->setCellValue('E' . $filas, $dato->getFecha()->format('d-m-Y'));
                        if( $dato->getHoraEntrada()){

                            $excel->setCellValue('F' . $filas, $dato->getHoraEntrada()->format('H:i:s'));

                        }else{

                            $excel->setCellValue('F' . $filas, '--------');
                        }
                        if( $dato->getHoraSalida()){

                            $excel->setCellValue('G' . $filas, $dato->getHoraSalida()->format('H:i:s'));

                        }else{

                            $excel->setCellValue('G' . $filas, '--------');
                        }
                        if( $dato->getHoraEntradaTarde()){

                            $excel->setCellValue('H' . $filas, $dato->getHoraEntradaTarde()->format('H:i:s'));

                        }else{

                            $excel->setCellValue('H' . $filas, '--------');
                        }
                        if( $dato->getHoraSalidaTarde()){

                            $excel->setCellValue('I' . $filas, $dato->getHoraSalidaTarde()->format('H:i:s'));

                        }else{

                            $excel->setCellValue('I' . $filas, '--------');
                        }
                        $suma1 = 0;
                        if($dato->getHoraSalida()){

                            if ($dato->getHoraEntrada()){

                                $intervaloM = $dato->getHoraSalida()->diff($dato->getHoraEntrada());
                                $suma1 = $intervaloM->format('%H');
                            }
                            else{

                                $excel->setCellValue('J' . $filas, "--------");
                            }


                            if($dato->getHoraSalidaTarde()){

                                if($dato->getHoraEntradaTarde()) {

                                    $intervaloT = $dato->getHoraSalidaTarde()->diff($dato->getHoraEntradaTarde());
                                    $suma1 = $suma1 + $intervaloT->format('%H');
                                    $excel->setCellValue('J' . $filas, $suma1);
                                }
                                else{

                                    $excel->setCellValue('J' . $filas, "--------");
                                }
                            }
                            else{

                                $suma1 = $intervaloM->format('%H');
                                $excel->setCellValue('J' . $filas, $suma1);
                            }

                        }
                        else{

                            if($dato->getHoraSalidaTarde()){

                                if ($dato->getHoraEntradaTarde()){

                                    $intervaloT = $dato->getHoraSalidaTarde()->diff($dato->getHoraEntradaTarde());
                                    $suma1 = $intervaloT->format('%H');
                                    $excel->setCellValue('J' . $filas, $suma1);
                                }
                                else{

                                    $excel->setCellValue('J' . $filas, "--------");

                                }
                            }
                            else{

                                $excel->setCellValue('J' . $filas, "--------");
                            }
                        }

                        $filas++;

                    }

                    $phpExcelObject->getActiveSheet()->setTitle('Listado de Accesos');
                    $phpExcelObject->setActiveSheetIndex(0);

                    $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');

                    $response = $this->get('phpexcel')->createStreamedResponse($writer);

                    $dispositionHeader = $response->headers->makeDisposition(
                        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                        'informeAccesos.xlsx'
                    );

                    $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                    $response->headers->set('Pragma', 'public');
                    $response->headers->set('Cache-Control', 'maxage=1');
                    $response->headers->set('Content-Disposition', $dispositionHeader);

                    return $response;
                }

          }

          return $this->render('informes/excel.html.twig', [

              'form' => $form->createView()
          ]);
      }

    /**
     * @Route("/informe/pdf",name="informe_pdf", methods={"GET", "POST"})
     */

    public function pdfAction(Request $request, AccesosRepositoy $accesosRepositoy, EmpleadosRepository $empleadosRepository, Environment $twig)
    {

        $form = $this->createForm(InformeType::class);
        $form->handleRequest($request);
        $accesos = 0;
        if ($form->isSubmitted() && $form->isValid()) {


            $fechaInicial = $form->get('fechaPrincipio')->getData();
            $fechaFinal = $form->get('fechaFinal')->getData();
            $buscar = $form->get('empleado')->getData();

            if($fechaInicial > $fechaFinal){

                $this->addFlash('error','La fecha inicial debe de ser menor  que la fecha final');
                return $this->redirectToRoute('informe_pdf');
            }
           if($fechaInicial->diff($fechaFinal)->format('%m') > 3){

               $this->addFlash('error','Error: maximo 3 meses');
                return  $this->redirectToRoute('informe_pdf');
            }
           else{

               if($fechaInicial->diff($fechaFinal)->format('%m') < 1){
                   $this->addFlash('error','Error: minimo 1 mes');
                   return  $this->redirectToRoute('informe_pdf');
               }
           }

            if (!$buscar) {

                $accesos = $accesosRepositoy->obtenerAccesosPorFechas($fechaInicial, $fechaFinal);

            } else {

                $empleado = $empleadosRepository->obtenerEmpleadoApellidos($buscar);

                if (!$empleado) {

                    $this->addFlash('error', 'Error: No se ha encotrado ningún empleado con ese dni');
                } else {

                    $accesos = $accesosRepositoy->obtenerAccesosFechasApellidos($fechaInicial, $fechaFinal, $empleado[0]->getId());
                }

            }

            if (!$accesos) {

                $this->addFlash('error', 'Error: No se ha encontrado ningún acceso');

            } else {

                $mpdfService = new MpdfService();

                $html =  $twig->render('informes/pdf.html.twig',[

                    'accesos'=> $accesos

                ]);

                return $mpdfService->generatePdfResponse($html);
            }

        }

        return $this->render('informes/pdfForm.html.twig', [

            'form' => $form->createView()
        ]);
    }
}