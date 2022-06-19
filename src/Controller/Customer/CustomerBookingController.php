<?php

namespace App\Controller\Customer;

use DateTime;
use App\Entity\Salon;
use App\Entity\Booking;
use App\Form\BookingCustomerType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use App\Service\CheckBookingStatus;
use App\Repository\BookingRepository;
use const App\Entity\STATUS_CANCELED;
use App\Repository\CoiffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 *  @Route("/account/booking")
 *  @isGranted("ROLE_CLIENT", message="Vous n'êtes pas connecté.")
 */
class CustomerBookingController extends AbstractController
{
    
    
    // Gestion des réservation par le client

    /**
     * @Route("/", name="customer_booking_dashboard", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('customer/dashboard.html.twig');
    }

    /**
     * @Route("/mes-rendez-vous", name="customer_booking_index", methods={"GET"})
     */
    public function bookingList(UserRepository $userRepository, CheckBookingStatus $checkBookingStatus, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        
        $booking = $user->getBookings();
        $checkBookingStatus->checkBookingStatus();
        
        return $this->render('customer/booking/index.html.twig', [
            'bookings' => $booking

        ]);
    }

    /**
     * @Route("/salons", name="customer_booking_salon")
     */
    public function chooseCustomerSalon(SalonRepository $salonRepository): Response
    {
        
        $salons = $salonRepository->findBy(['isBookingOnline' => true]);

        return $this->renderForm('customer/booking/salon.html.twig', [
            'salons' => $salons
        ]);
    }

    
    /**
     * @Route("/new/salon/{id}", name="customer_booking_new", methods={"GET", "POST"})
     */
    public function bookingCustomerNew(Salon $salon, UserRepository $userRepository, CheckBookingStatus $checkBookingStatus, Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $booking = new Booking();
        $form = $this->createForm(BookingCustomerType::class, $booking,['coiffeurs' => $salon->getCoiffeurs()]);
        $form->handleRequest($request);
        $slots = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            $startAt = $booking->getBeginAt()->format('Y-m-d H:i');
            $endAt = new DateTime($startAt);
            $endAt->add($booking->getProduct()->getDuration());
            
            $booking->setBookerFullname($user->getFirstname().' '.$user->getLastname())
            ->setEndAt($endAt)
            ->setBooker($user)
            ->setSalon($salon)
            ->setProduct($booking->getProduct())
            ->setCoiffeur($booking->getCoiffeur())
            ->setBookerEmail($user->getEmail())
            ->setBookerPhone($user->getPhone())
            ->setTitle(strtolower($booking->getBookerFullname()))
            ->setColor($booking->getProduct()->getCategory()->getColor())
            ->setProductName($booking->getProduct()->getName())
            ->setProductDuration($booking->getProduct()->getDuration())
            ->setProductPrice($booking->getProduct()->getPrice());
            
            if(!empty($booking->getProduct()->getDetail())){
                $booking->setProductDetail($booking->getProduct()->getDetail());
            }
            
            
            $from = new \DateTime();
            $to = new \DateTime('+ 1 month');

            $interval = \DateInterval::createFromDateString('1 day');
            $days = new \DatePeriod($from, $interval, $to);
            
            $slots = [];
            foreach ($days as $day) {
                
                $slots[] = $booking->getCoiffeur()->getAvailableSlots($day);
            }


            if(!$booking->isBookable()){
                $this->addFlash('warning', 'Ce créneau est déjà pris' );
                
            }else{

                $entityManager->persist($booking);
                $entityManager->flush();
                $email = (new TemplatedEmail())
                    ->priority(Email::PRIORITY_HIGH)
                    ->to($booking->getBookerEmail())
                    ->subject('Votre réservation du '.$booking->getBeginAt()->format('d/m/Y à H:i'))
                    ->htmlTemplate('email/booking/booking_confirmation_new.html.twig')
                    ->context([
                        'booking' => $booking,
                        'price' => $booking->getProductPrice() / 100
                    ]);
            

                $mailer->send($email);
                $this->addFlash('success', 'Le rendez-vous est bien enregistré. Vérifiez vos emails');
                return $this->redirectToRoute('customer_booking_index');
            }
        }
        
        return $this->renderForm('customer/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
            'salon' => $salon,
            'slots' =>$slots
        ]);

    }

    /**
     * @Route("/ajax-booking-customer", name="booking_ajax_customer", methods={"POST", "GET"})
     * @isGranted("ROLE_CLIENT", message="Vous n'avez pas accès à cette section.")
     */
    public function ajaxBooking(Request $request, CoiffeurRepository $coiffeurRepository)
    {

            $coiffeur = $coiffeurRepository->find($request->request->get('id'));

            $from = new \DateTime();
            $to = new \DateTime('+ 1 month');
            
            $interval = \DateInterval::createFromDateString('1 day');
            $days = new \DatePeriod($from, $interval, $to);
            
            $slots = [];
            foreach ($days as $day) {
                
                $slots[] = $coiffeur->getAvailableSlots($day);
            }

            $html = '';
            if($slots){
            //get the HTML markup corresponding to the table
                $data = $this->render('customer/booking/slot.html.twig', array(
                    'slots' => $slots,
                    'coiffeur' => $coiffeur->getFirstname()
                ));

                $html = $data->getContent();
            }
            
    
            $response = $this->json(['data' => $html],200);
            $response->headers->set('Content-Type', 'application/json; charset=utf-8');
    
            return $response;
    }


    /**
     * @Route("/{id}", name="customer_booking_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showBooking(UserRepository $userRepository, Security $security, BookingRepository $bookingRepository, Booking $booking): Response
    {
        $currentUser = $userRepository->findOneBy(['email' => $security->getUser()->getUserIdentifier()]);
        if($booking->getBookerEmail() !== $currentUser->getEmail()){
            throw new AccessDeniedException('Désolé '.$currentUser->getFirstname().', vous ne pouvez pas accéder aux réservations des autres clients ;)');
        }

        if(empty($booking->getProduct())){

            $booking->setProductPrice($booking->getProductPrice()/100);
        }else{
            $booking->getProduct()->setPrice($booking->getProduct()->getPrice()/100);
        }

        $lastBookings = $bookingRepository->findBy(['bookerEmail' => $booking->getBookerEmail(), 'status' => 'warning']);
        
        return $this->render('customer/booking/show.html.twig', [
            'booking' => $booking,
            'lastBookings' => $lastBookings,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="customer_booking_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editBookingCustomer(Request $request, Booking $booking, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $salon = $booking->getSalon();
        $form = $this->createForm(BookingCustomerType::class, $booking,['coiffeurs' => $salon->getCoiffeurs(),'date' => $booking->getBeginAt()->format('Y-m-d H:i')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
                $startAt = $booking->getBeginAt()->format('Y-m-d H:i');
                $endAt = new DateTime($startAt);
                $endAt->add($booking->getProductDuration());
    
                
                    $booking->setBookerFullname($booking->getBooker()->getFirstname().' '.$booking->getBooker()->getLastname())
                        ->setEndAt($endAt)
                        ->setBookerEmail($booking->getBooker()->getEmail())
                        ->setBookerPhone($booking->getBooker()->getPhone())
                        ->setTitle(strtolower($booking->getBookerFullname()))
                        ->setColor($booking->getCoiffeur()->getColor())
                        ->setProductName($booking->getProduct()->getName())
                        ->setProductDuration($booking->getProduct()->getDuration())
                        ->setProductPrice($booking->getProduct()->getPrice());
                
                        if(!empty($booking->getProduct()->getDetail())){
                            $booking->setProductDetail($booking->getProduct()->getDetail());
                        }
                

                    
                        $entityManager->persist($booking);
                        $entityManager->flush();
                        if($booking->getBooker()){

                            $email = (new TemplatedEmail())
                                ->priority(Email::PRIORITY_HIGH)
                                ->to($booking->getBookerEmail())
                                ->subject('Votre réservation du '.$booking->getBeginAt()->format('d/m/Y à H:i'))
                                ->htmlTemplate('email/booking/booking_confirmation_modify.html.twig')
                                ->context([
                                    'booking' => $booking,
                                    'price' => $booking->getProductPrice() / 100
                                ]);
                
            
                            $mailer->send($email);
                        }
                        $this->addFlash('success', 'Le rendez-vous est bien modifié');
                        return $this->redirectToRoute('customer_booking_index');

        }

        return $this->renderForm('customer/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="customer_booking_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function deleteBooking(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_booking_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/cancel/{id}", name="customer_booking_cancel", requirements={"id"="\d+"})
     */
    public function cancelEvent(Booking $booking,UserRepository $userRepository, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $currentUser = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        if($booking->getBookerEmail() !== $currentUser->getEmail()){
            throw new AccessDeniedException('Ben alors '.$currentUser->getFirstname().', c\'est pas gentil de supprimer les réservations des autres ! ;)');
        }
            
                $booking->setIsCancel(1)
                        ->setStatus(STATUS_CANCELED)
                        ->setCancelledAt(new DateTime())
                        ->setCancellerRoles($currentUser->getRoles());
                
                
                    $entityManager->flush();

                    $email = (new TemplatedEmail())
                
                        ->priority(Email::PRIORITY_HIGH) 
                        ->to($booking->getBookerEmail())
                        ->subject('Votre annulation du '.$booking->getBeginAt()->format('d/m/Y à H:i'))
                        ->htmlTemplate('email/booking/booking_cancelled.html.twig')
                        ->context([
                            'booking' => $booking,
                            'price' => $booking->getProductPrice() / 100
                        ]);
                
    
                    $mailer->send($email);
                


        $this->addFlash('danger', 'Votre rendez-vous à bien été annulé.');
         return $this->redirectToRoute('customer_booking_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/calendar/", name="admin_calendar", methods={"GET"})
     */
    /* public function showCalendar(): Response
    {
        
        return $this->render('customer/booking/calendar.html.twig');
    } */

    // Fin de gestion du planning
    
}
