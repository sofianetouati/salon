<?php

namespace App\Controller\Admin;

use App\Entity\RestReason;
use App\Form\RestReasonType;
use App\Repository\RestReasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/coiffeur/rest/reason")
 * @isGranted("ROLE_ADMIN", message="Vous n'avez pas accès à cette section.")
 */
class RestReasonController extends AbstractController
{
    /**
     * @Route("/", name="rest_reason_index", methods={"GET"})
     */
    public function index(RestReasonRepository $restReasonRepository): Response
    {
        return $this->render('admin/coiffeur/reason/index.html.twig', [
            'restReasons' => $restReasonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rest_reason_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restReason = new RestReason();
        $form = $this->createForm(RestReasonType::class, $restReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restReason);
            $entityManager->flush();

            return $this->redirectToRoute('rest_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/reason/new.html.twig', [
            'restReason' => $restReason,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rest_reason_show", methods={"GET"})
     */
    public function show(RestReason $restReason): Response
    {
        return $this->render('admin/coiffeur/reason/show.html.twig', [
            'rest_reason' => $restReason,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rest_reason_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RestReason $restReason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestReasonType::class, $restReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rest_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/reason/edit.html.twig', [
            'rest_reason' => $restReason,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rest_reason_delete", methods={"POST"})
     */
    public function delete(Request $request, RestReason $restReason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restReason->getId(), $request->request->get('_token'))) {
            $entityManager->remove($restReason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rest_reason_index', [], Response::HTTP_SEE_OTHER);
    }
}
