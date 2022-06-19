<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\Mime\Address;
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
 *  @Route("/admin/manager")
 *  @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
 */
class ManagerController extends AbstractController
{
    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }


    // Gestion des managers

    /**
     * @Route("/", name="admin_manager_all", methods={"GET"})
     */
    public function showManagers(UserRepository $userRepository): Response
    {
        return $this->render('admin/manager/index.html.twig', [
            'managers' => $userRepository->findManagers(),
        ]);
    }

    /**
     * @Route("/new", name="admin_manager_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour ajouter un manager.")
     */
    public function newManager(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_MANAGER"])
                ->setIsVerified(true)
                ->setPassword(
                    $userPasswordHasher->hashPassword($user,'coiffure'))
                ->setCreatedAt(new DateTime("now"));

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
    

            return $this->redirectToRoute('admin_manager_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/manager/new.html.twig', [
            'manager' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_manager_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showManager(User $user): Response
    {
        return $this->render('admin/manager/show.html.twig', [
            'manager' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_manager_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour modifier un manager.")
     */
    public function editManager(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(["ROLE_MANAGER"]);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manager_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/manager/edit.html.twig', [
            'manager' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_manager_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_ADMIN", message="Vous n'avez pas les droits pour supprimer un manager.")
     */
    public function deleteManager(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($user);
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('admin_manager_all', [], Response::HTTP_SEE_OTHER);
    }

    //Fin Managers
    
}
