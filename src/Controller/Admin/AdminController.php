<?php

namespace App\Controller\Admin;

use App\Entity\Rest;
use App\Entity\User;
use App\Entity\Salon;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use Symfony\Component\Mime\Address;
use App\Repository\BookingRepository;
use App\Repository\CoiffeurRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;


/**
 *  @Route("/admin")
 *  @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette page.")
 */
class AdminController extends AbstractController
{
    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }


    /**
     * @Route("/", name="admin_index")
     */
    public function dashboard(UserRepository $userRepository, CoiffeurRepository $coiffeurRepository, BookingRepository $bookingRepository, SalonRepository $salonRepository ): Response
    {
        // On récupère l'utilisateur connecté
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        
        if($this->isGranted('ROLE_ADMIN')){
            $salons = $salonRepository->findAll();
            $bookings = $bookingRepository->findAll();
            $coiffeurs = $coiffeurRepository->findAll();
        }else{
            $salons = $salonRepository->findBy(['manager' => $user]);
            $bookings = $bookingRepository->findBySalon($salons);
            
            $coiffeurs = $coiffeurRepository->findBySalon($salons);
            
        }

        return $this->render('admin/dashboard.html.twig',[
            'salons' => $salons,
            'bookings' => $bookings,
            'coiffeurs' => $coiffeurs,
        ]);

    }

    // Gestion des administrateurs

    /**
     * @Route("/profil", name="admin_all", methods={"GET"})
     */
    public function showAdmins(UserRepository $userRepository): Response
    {
        return $this->render('admin/profil/index.html.twig', [
            'admins' => $userRepository->findAdmin(),
        ]);
    }

    /**
     * @Route("/profil/new", name="admin_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez les droits pour créer un administrateur.")
     */
    public function newAdmin(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_ADMIN","ROLE_MANAGER"])
                ->setIsVerified(true)
                ->setPassword(
                    $userPasswordHasher->hashPassword($user,'coiffure'));

            $entityManager->persist($user);
            $entityManager->flush();
            
            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);
            } catch (ResetPasswordExceptionInterface $e) {
                // If you want to tell the user why a reset email was not sent, uncomment
                // the lines below and change the redirect to 'app_forgot_password_request'.
                // Caution: This may reveal if a user is registered or not.
                //
                // $this->addFlash('reset_password_error', sprintf(
                //     'There was a problem handling your password reset request - %s',
                //     $e->getReason()
                // ));
    
                return $this->redirectToRoute('app_check_email');
            }
    
            $email = (new TemplatedEmail())
                ->from(new Address('contact@elitesbarbershops.fr', 'Elites Barber Shops'))
                ->to($user->getEmail())
                ->subject('Votre compte à bien été créé')
                ->htmlTemplate('email/reset_password/auto_created.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                ])
            ;
    
            $mailer->send($email);
    

            return $this->redirectToRoute('admin_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profil/new.html.twig', [
            'admin' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/profil/{id}", name="admin_show", methods={"GET"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette page.")
     */
    public function showAdmin(User $user): Response
    {
        return $this->render('admin/profil/show.html.twig', [
            'admin' => $user,
        ]);
    }

    /**
     * @Route("/profil/edit/{id}", name="admin_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez les droits pour modifier un administrateur.")
     */
    public function editAdmin(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profil/edit.html.twig', [
            'admin' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/profil/{id}", name="admin_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez les droits pour supprimer un administrateur.")
     */
    public function deleteAdmin(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($user);
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('admin_all', [], Response::HTTP_SEE_OTHER);
    }

    //Fin Administrateurs

    
    
}
