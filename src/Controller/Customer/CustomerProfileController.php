<?php
namespace App\Controller\Customer;

use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 *  @Route("/account/profile")
 *  @isGranted("ROLE_CLIENT", message="Vous n'êtes pas connecté.")
 */
class CustomerProfileController extends AbstractController
{
    /**
     * @Route("/{id}", name="customer_profile_index", methods={"GET"})
     */
    public function profileShow(User $user, UserRepository $userRepository): Response
    {
        $currentUser = $userRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);

        if(!$user|| $user != $currentUser){
            throw new AccessDeniedException('Désolé '.$user->getFirstname().', vous ne pouvez pas accéder au compte des autres clients ;)');
        }
        $user = $userRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        $day1 = $user->getCreatedAt();
        $day2 = new DateTime();
        $ago = $day2->diff($day1)->format('depuis %m mois');
        

        
        return $this->render('customer/profile.html.twig', [
            'ago' => $ago,
            'user' => $user

        ]);

    }
}

