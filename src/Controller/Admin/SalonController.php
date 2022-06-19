<?php

namespace App\Controller\Admin;

use App\Entity\Salon;
use App\Form\SalonType;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use App\Repository\CoiffeurRepository;
use App\Service\CheckBookingStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 *  @Route("/admin/salon")
 *  @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
 */
class SalonController extends AbstractController
{

    
    // Gestion des salons

    /**
     * @Route("/", name="admin_salon_all", methods={"GET"})
     */
    public function showSalons(UserRepository $userRepository, SalonRepository $salonRepository): Response
    {
        $user = $userRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);

    
        if(in_array('ROLE_MANAGER', $user->getRoles())){
            $salons = $user->getSalons();
        }elseif(in_array('ROLE_ADMIN', $user->getRoles())){
            $salons = $salonRepository->findAll();
        }

        return $this->render('admin/salon/index.html.twig', [
            'salons' => $salons,
        ]);
    }

    /**
     * @Route("/new", name="admin_salon_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Seul le directeur peut créer un salon")
     */
    public function newSalon(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salon = new Salon();
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salon);
            $entityManager->flush();

            return $this->redirectToRoute('admin_salon_show', [
                'id' => $salon->getId(),
            ]);
        }
        
        return $this->renderForm('admin/salon/new.html.twig', [
            'salon' => $salon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_salon_show", methods={"GET"})
     */
    public function showSalon(Salon $salon, CheckBookingStatus $checkBookingStatus): Response
    {
        $checkBookingStatus->checkSalonBookingStatus();

        return $this->render('admin/salon/show.html.twig', [
            'salon' => $salon,

        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_salon_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Seul le directeur peut modifier un salon")
     */
    public function editSalon(Request $request, Salon $salon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($salon->getCoiffeurs() as $coiffeur) {
                    $coiffeur->setJobStartAt($salon->getOpenAt())
                        ->setJobEndAt($salon->getCloseAt());
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_salon_show', [
                'id' => $salon->getId(),
            ]);
        }

        return $this->renderForm('admin/salon/edit.html.twig', [
            'salon' => $salon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_salon_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN", message="Seul le directeur peut supprimer un salon")
     */
    public function deleteSalon(Request $request, Salon $salon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salon->getId(), $request->request->get('_token'))) {
            

            if($salon->getCoiffeurs()->count() === 0){
                
                $entityManager->remove($salon);
                $entityManager->flush();
            }else{

                $this->addFlash('danger','Vous devez d\'abord réaffecter les coiffeurs dans d\'autres salons avant de pouvoir supprimer cet établissement.');
                return $this->redirectToRoute('admin_salon_all');
            }
            
        }

        return $this->redirectToRoute('admin_salon_all', [], Response::HTTP_SEE_OTHER);
    }
    // Fin de gestion des salons

}
