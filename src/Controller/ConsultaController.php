<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Form\ConsultaType;
use App\Repository\ConsultaRepository;
use App\Repository\PacienteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consulta")
 */
class ConsultaController extends AbstractController
{
    /**
     * @Route("/", name="app_consulta_index", methods={"GET"}, options={"expose"=true})
     */
    public function index(ConsultaRepository $consultaRepository): Response
    {
        return $this->render('consulta/index.html.twig', [
            'consultas' => $consultaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_consulta_new", methods={"GET", "POST"},options={"expose"=true})
     */
    public function new(Request $request, ConsultaRepository $consultaRepository, $id, PacienteRepository $pacienteRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $paciente= $pacienteRepository->find($id);
        $usuario = $userRepository->find($user);
        $consultum = new Consulta();
        $form = $this->createForm(ConsultaType::class, $consultum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultum->setUser($user);
            $consultum->setPaciente($paciente);
            $consultaRepository->add($consultum, true);

            return $this->redirect($request->getUri());
        }

        return $this->renderForm('consulta/new.html.twig', [
            'paciente'=> $paciente,
            'consultas' => $consultaRepository->findBy(
                ['paciente'=> $paciente,
                'user'=>$usuario
                ]
                
            ),
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_consulta_show", methods={"GET"})
     */
    public function show(Consulta $consultum): Response
    {
        return $this->render('consulta/show.html.twig', [
            'consultum' => $consultum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_consulta_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Consulta $consultum, ConsultaRepository $consultaRepository): Response
    {
        $form = $this->createForm(ConsultaType::class, $consultum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultaRepository->add($consultum, true);

            return $this->redirectToRoute('app_consulta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consulta/edit.html.twig', [
            'consultum' => $consultum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_consulta_delete", methods={"POST"})
     */
    public function delete(Request $request, Consulta $consultum, ConsultaRepository $consultaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultum->getId(), $request->request->get('_token'))) {
            $consultaRepository->remove($consultum, true);
        }

        return $this->redirectToRoute('app_consulta_index', [], Response::HTTP_SEE_OTHER);
    }
}
