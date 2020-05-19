<?php


namespace AppBundle\Controller;


use AppBundle\Form\Type\InformeType;
use AppBundle\Repository\AccesosRepositoy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class FicherosExcelController extends Controller
{

    /**
     * @Route("/informe",name="informe_excel", methods={"GET", "POST"})
     */

      public function excelAction(Request $request, AccesosRepositoy $accesosRepositoy)
      {

          $form = $this->createForm(InformeType::class);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

              $fechaInicial = $form->get('fechaPrincipio')->getData();
              $fechaFinal = $form->get('fechaFinal')->getData();

              $accesos = $accesosRepositoy->obtenerAccesosPorFechas($fechaInicial, $fechaFinal);


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

              $filas = 8;


              foreach ($accesos as $dato) {

                  $excel->setCellValue('D' . $filas, $dato->getEmpleado());
                  $excel->setCellValue('E' . $filas, $dato->getFecha());
                  $excel->setCellValue('F' . $filas, $dato->getHoraEntrada());
                  $excel->setCellValue('G' . $filas, $dato->getHoraSalida());
                  $excel->setCellValue('H' . $filas, $dato->getHoraEntradaTarde());
                  $excel->setCellValue('I' . $filas, $dato->getHoraSalidaTarde());

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

          return $this->render('informes/excel.html.twig', [

              'form' => $form->createView()
          ]);
      }
}