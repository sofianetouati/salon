<?php

namespace App\Controller\Admin;

use App\Entity\Rest;
use App\Form\RestType;
use App\Repository\CoiffeurRepository;
use App\Repository\RestRepository;
use App\Repository\SalonRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/coiffeur/rest")
 * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
 */
class RestController extends AbstractController
{
    /**
     * @Route("/", name="rest_index", methods={"GET"})
     */
    public function index(RestRepository $restRepository,UserRepository $userRepository, CoiffeurRepository $coiffeurRepository, SalonRepository $salonRepository): Response
    {
        $user = $userRepository->findBy(['email'=>$this->getUser()->getUserIdentifier()]);

        if ($this->isGranted('ROLE_ADMIN')){
            $rests = $restRepository->findAll();
        }else{

        
            $salon = $salonRepository->findOneBy(['manager' => $user]);
            $coiffeurs = $coiffeurRepository->findBySalon($salon);
            $rests = [];
            foreach ($coiffeurs as $coiffeur) {
                foreach ($coiffeur->getRests() as $rest ) {
                    $rests[] = $rest;
                }
            }
            //dd($rests);
        }

        return $this->render('admin/coiffeur/rest/index.html.twig', [
            'rests' => $rests,
        ]);
    }

    /**
     * @Route("/new", name="rest_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rest = new Rest();
        $form = $this->createForm(RestType::class, $rest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rest);
            $entityManager->flush();

            return $this->redirectToRoute('rest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/rest/new.html.twig', [
            'rest' => $rest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rest_show", methods={"GET"}, priority="-1")
     */
    public function show(Rest $rest): Response
    {
        return $this->render('admin/coiffeur/rest/show.html.twig', [
            'rest' => $rest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rest_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rest $rest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestType::class, $rest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/rest/edit.html.twig', [
            'rest' => $rest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rest_delete", methods={"POST"})
     */
    public function delete(Request $request, Rest $rest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rest_index', [], Response::HTTP_SEE_OTHER);
    }
}
