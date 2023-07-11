<?php

namespace App\Controller;

use App\Entity\Paciente;
use App\Form\PacienteType;
use App\Repository\PacienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/paciente")
 */
class PacienteController extends AbstractController
{
    /**
     * @Route("/", name="app_paciente_index", methods={"GET","POST"})
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
       
        return $this->render('paciente/index.html.twig', [
             
        ]);
    }

    /**
    * @Route("/server-processing", name="server_processing", options={"expose"=true})
    */
    public function serverProcessing(EntityManagerInterface $entityManager)
    {
      

        /*ORDER BY sd.id DESC*/

        $dql = 'SELECT sd FROM App:Paciente sd';
        $dqlCountFiltered = 'SELECT count(sd) FROM App:Paciente sd';

        $sqlFilter = '';

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            $sqlFilter .= "
                sd.Nombre LIKE '%".$strMainSearch."%' OR "
                ."sd.Apellido LIKE '%".$strMainSearch."%' OR "
                ."sd.cedula LIKE '%".$strMainSearch."%'
                ";
        }

        // Filter columns with AND restriction
        $strColSearch = '';
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                $strColSearch .= ' sd.'.$column['name']." LIKE '%".$column['search']['value']."%'";
            }
        }
        if (!empty($sqlFilter)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            $dql .= ' WHERE'.$sqlFilter;
            $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            /*var_dump($dql);
            var_dump($dqlCountFiltered);
            exit;*/
        }

        //var_dump($dql); exit;

        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

        $data = [];
        foreach ($items as  $value) {
            $data[] = [
               
                $value->getNombre(),
                $value->getApellido(),
                $value->getCedula(),
                $value->getSexo(),
                $value->getFechaNacimiento(),
                $value->getFechaIngreso(),
                $value->displayPhoto(),
                $value->getId()
            ];
        }

        $recordsTotal = $entityManager
            ->createQuery('SELECT count(sd) FROM App:Paciente sd')
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        return $this->json([
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        ]);
    }

    /**
     * @Route("/new", name="app_paciente_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PacienteRepository $pacienteRepository): Response
    {
        $paciente = new Paciente();
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=  $form->get('image_profile')->getData();
            if ($file) {
         
                $strm = fopen($file->getRealPath(),'rb');
         
                // Move the file to the directory where brochures are stored
                try {

                  $paciente->setImageProfile(stream_get_contents($strm));

                 
  
                
                } catch (Exception $e) {
                    throw  new \Exception('Error al subir archivos');
                    // ... handle exception if something happens during file upload
                }

                
    
            }
            $pacienteRepository->add($paciente, true);

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/new.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_paciente_show", methods={"GET"})
     */
    public function show(Paciente $paciente): Response
    {
        return $this->render('paciente/show.html.twig', [
            'paciente' => $paciente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_paciente_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Paciente $paciente, PacienteRepository $pacienteRepository): Response
    {
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=  $form->get('image_profile')->getData();
            if ($file) {
         
                $strm = fopen($file->getRealPath(),'rb');
         
                // Move the file to the directory where brochures are stored
                try {

                  $paciente->setImageProfile(stream_get_contents($strm));

                 
  
                
                } catch (Exception $e) {
                    throw  new \Exception('Error al subir archivos');
                    // ... handle exception if something happens during file upload
                }

                
    
            }
            $pacienteRepository->add($paciente, true);

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/edit.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_paciente_delete", methods={"POST"})
     */
    public function delete(Request $request, Paciente $paciente, PacienteRepository $pacienteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paciente->getId(), $request->request->get('_token'))) {
            $pacienteRepository->remove($paciente, true);
        }

        return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
    }
}
