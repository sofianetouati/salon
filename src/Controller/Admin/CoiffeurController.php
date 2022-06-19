<?php

namespace App\Controller\Admin;

use App\Entity\Coiffeur;
use App\Form\CoiffeurType;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use App\Repository\CoiffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 *  @Route("/admin/coiffeur")
 *  @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
 */
class CoiffeurController extends AbstractController
{

    //Gestion des coiffeurs

    /**
     * @Route("/", name="admin_coiffeur_all", methods={"GET"})
     */
    public function showCoiffeurs(UserRepository $userRepository, CoiffeurRepository $coiffeurRepository): Response
    {

        $user = $userRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);

    
        if(in_array('ROLE_MANAGER', $user->getRoles())){
            $coiffeurs = [];
            foreach ($user->getSalons() as $salon) {
                foreach ($salon->getCoiffeurs() as $coiff) {
                    $coiffeurs[] = $coiff;
                }
            }
            
        }elseif(in_array('ROLE_ADMIN', $user->getRoles())){
            $coiffeurs = $coiffeurRepository->findAll();
        }
        
        return $this->render('admin/coiffeur/index.html.twig', [
            'coiffeurs' => $coiffeurs,
        ]);
    }

    /**
     * @Route("/new", name="admin_coiffeur_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas accès à cette section.")
     */
    public function newCoiffeur(Request $request, SalonRepository $salonRepository, EntityManagerInterface $entityManager): Response
    {
        $salons = $salonRepository->findAll();
        $coiffeur = new Coiffeur();
        $form = $this->createForm(CoiffeurType::class, $coiffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $coiffeur->setIslinked(true);
            $entityManager->persist($coiffeur);
            $entityManager->flush();

            return $this->redirectToRoute('admin_coiffeur_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/new.html.twig', [
            'coiffeur' => $coiffeur,
            'salons' =>$salons,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_coiffeur_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showCoiffeur(Coiffeur $coiffeur): Response
    {

        return $this->render('admin/coiffeur/show.html.twig', [
            'coiffeur' => $coiffeur,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_coiffeur_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas accès à cette section.")
     */
    public function editCoiffeur(Request $request, Coiffeur $coiffeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoiffeurType::class, $coiffeur, [
            'start' => $coiffeur->getSalon()->getOpenAt()->format('H:i'),
            'stop' => $coiffeur->getSalon()->getCloseAt()->format('H:i')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_coiffeur_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coiffeur/edit.html.twig', [
            'coiffeur' => $coiffeur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_coiffeur_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas accès à cette section.")
     */
    public function deleteCoiffeur(Request $request, Coiffeur $coiffeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coiffeur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coiffeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_coiffeur_all', [], Response::HTTP_SEE_OTHER);
    }

    // Fin Coiffeurs
    
}
