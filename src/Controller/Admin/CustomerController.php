<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\CheckBookingStatus;
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
 *  @Route("/admin/customer")
 *  @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette page.")
 */
class CustomerController extends AbstractController
{
    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }


    // Gestion des Clients

    /**
     * @Route("/", name="admin_customer_all", methods={"GET"})
     */
    public function showCustomers(UserRepository $userRepository): Response
    {
        return $this->render('admin/customer/index.html.twig', [
            'customers' => $userRepository->findCustomers(),
        ]);
    }

    /**
     * @Route("/new", name="admin_customer_new", methods={"GET", "POST"})
     */
    public function newCustomer(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_CLIENT"])
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
    

            return $this->redirectToRoute('admin_customer_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/customer/new.html.twig', [
            'customer' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_customer_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showCustomer(User $user, CheckBookingStatus $checkBookingStatus): Response
    {
        $checkBookingStatus->checkCustomerBookingStatus($user->getId());

        return $this->render('admin/customer/show.html.twig', [
            'customer' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_customer_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editCustomer(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_customer_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/customer/edit.html.twig', [
            'customer' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_customer_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function deleteCustomer(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($user);
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('admin_customer_all', [], Response::HTTP_SEE_OTHER);
    }

    //Fin Clients
    
}
