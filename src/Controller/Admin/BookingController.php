<?php

namespace App\Controller\Admin;

use DateTime;
use DateInterval;
use App\Entity\Salon;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\PhoneBookingType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use App\Service\CheckBookingStatus;
use App\Repository\BookingRepository;
use const App\Entity\STATUS_CANCELED;
use App\Repository\CoiffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *  @Route("/admin/booking")
 */
class BookingController extends AbstractController
{   
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
     
    // Gestion des plannings

    /**
     * @Route("/", name="admin_booking_all", methods={"GET"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminBookingList(UserRepository $userRepository, BookingRepository $bookingRepository, CheckBookingStatus $checkBookingStatus, EntityManagerInterface $em): Response
    {
        $user = $userRepository->findOneBy(['email'=> $this->getUser()->getUserIdentifier()]);

        $checkBookingStatus->checkBookingStatus();

        if($this->isGranted('ROLE_ADMIN')){
            $bookings = $bookingRepository->findAll();
        }else{

            $bookings = $bookingRepository->findBySalon($user->getSalons());
        }
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * @Route("/salons", name="admin_booking_salon")
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function chooseSalon(SalonRepository $salonRepository, UserRepository $userRepository): Response
    {
        //On prend l'utilisateur connecté
        $user = $userRepository->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);

        if($this->isGranted('ROLE_ADMIN')){
            $salon = $salonRepository->findAll();
        }else{

            $salon = $salonRepository->findBy(['manager' => $user]);
        }
        //dd($salon);

        return $this->renderForm('admin/booking/salon.html.twig', [
            'salon' => $salon

        ]);
    }

    /**
     * @Route("/new/salon/{id}", name="admin_booking_new", methods={"GET", "POST"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminNewBooking(Salon $salon, Request $request, EntityManagerInterface $entityManager, BookingRepository $bookingRepository, MailerInterface $mailer): Response
    {

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking,['coiffeurs' => $salon->getCoiffeurs()]);
        $form->handleRequest($request);
        //$slots = [];
        
        if ($form->isSubmitted() && $form->isValid()) {

            
            $startAt = $booking->getBeginAt()->format('Y-m-d H:i');
            $endAt = new DateTime($startAt);
            $endAt->add($booking->getProduct()->getDuration());
            
            $booking->setBooker($booking->getBooker())
            ->setBookerFullname($booking->getBooker()->getFirstname().' '.$booking->getBooker()->getLastname())
            ->setEndAt($endAt)
            ->setSalon($salon)
            ->setProduct($booking->getProduct())
            ->setCoiffeur($booking->getCoiffeur())
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
            
            
            
            /* $from = new \DateTime('today');
            $to = new \DateTime('+ 15 days');
            
            $interval = \DateInterval::createFromDateString('1 day');
            $days = new \DatePeriod($from, $interval, $to);
            
            $slots = [];
            foreach ($days as $day) {
                
                $slots[] = $booking->getCoiffeur()->getAvailableSlots($day);
            } */
            
            if(!$booking->isBookable()){
                $this->addFlash('warning', 'Ce créneau est déjà pris' );
                
            }else{
                $entityManager->persist($booking);
                $entityManager->flush();

                if($booking->getBooker()){
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
                }

                $this->addFlash('success', 'Le rendez-vous est bien enregistré.');
                return $this->redirectToRoute('admin_calendar');
            }
        }
        
        return $this->renderForm('admin/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
            'salon' => $salon,
            //'slots' =>$slots
        ]);

    }

    /**
     * @Route("/ajax-phone-booking-admin", name="phone_booking_ajax_admin", methods={"POST", "GET"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function ajaxPhoneBookingAdmin(EntityManagerInterface $entityManager, Request $request,SalonRepository $salonRepository, CoiffeurRepository $coiffeurRepository)
    {
        $dateJs = new DateTime($request->get('date'));
        $date = $dateJs->format('Y-m-d H:i');
        $dateFr = $dateJs->format('d/m/Y à H:i');

        $salon = $salonRepository->find($request->get('salonId'));
        $dispo = [];
        foreach ($salon->getCoiffeurs() as $coiffeur ) {
            if($coiffeur->getAvailableSlots($dateJs)){
                $dispo[] = [
                    'coiffeurId'=>$coiffeur->getId(),
                    'coiffeurName'=>ucfirst($coiffeur->getFirstname()).' '.strtoupper($coiffeur->getLastname())
                    ];
            }
        }

        return $this->json(['date'=>$date, 'dateFr'=>$dateFr, 'dispo' => $dispo],200);
            
    }

    /**
     * @Route("/ajax-booking-admin", name="booking_ajax_admin", methods={"POST", "GET"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function ajaxBookingAdmin(Request $request, CoiffeurRepository $coiffeurRepository)
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
            //get the HTML markup corresponding to the table
                $data = $this->render('admin/booking/slot.html.twig', array(
                    'slots' => $slots,
                    'coiffeur' => $coiffeur->getFirstname()
                ));

                $html = $data->getContent();
            
    
            $response = $this->json(['data' => $html],200);
            $response->headers->set('Content-Type', 'application/json; charset=utf-8');
    
            return $response;
    }

    /**
     * @Route("/{id}", name="admin_booking_show", methods={"GET"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminShowBooking(BookingRepository $bookingRepository, Booking $booking): Response
    {
    
        $now = new DateTime();
        if(empty($booking->getProduct())){

            $booking->setProductPrice($booking->getProductPrice()/100);
        }else{
            $booking->getProduct()->setPrice($booking->getProduct()->getPrice()/100);
        }

        

        $lastBookings = $bookingRepository->findBy(['bookerEmail' => $booking->getBookerEmail(), 'status' => 'warning']);
        
        return $this->render('admin/booking/show.html.twig', [
            'booking' => $booking,
            'lastBookings' => $lastBookings,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_booking_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminEditBooking(Request $request, Booking $booking, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $salon = $booking->getSalon();
        $form = $this->createForm(BookingType::class, $booking,['coiffeurs' => $salon->getCoiffeurs(),'date' => $booking->getBeginAt()->format('Y-m-d H:i')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($booking->getBooker()){
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
            }else{
                    $startAt = $booking->getBeginAt()->format('Y-m-d H:i');
                    $endAt = new DateTime($startAt);
                    $endAt->modify('+ 30 minutes');

                    $booking->setEndAt($endAt)
                        ->setSalon($booking->getCoiffeur()->getSalon())
                        ->setBookerFullname($booking->getBookerFullname())
                        ->setTitle(strtolower($booking->getBookerFullname()))
                        ->setColor($booking->getCoiffeur()->getColor())
                        ->setIsPhoneBooking(true);
            }
                    
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
                $entityManager->flush();
                return $this->redirectToRoute('admin_calendar');

        }

        return $this->renderForm('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_booking_delete", methods={"POST"}, requirements={"id"="\d+"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminDeleteBooking(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_calendar', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/cancel/{id}", name="admin_booking_cancel", requirements={"id"="\d+"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function AdminCancelEvent(Booking $booking, UserRepository $userRepository, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        
        $booking->setIsCancel(1)
                ->setStatus(STATUS_CANCELED)
                ->setCancelledAt(new DateTime())
                ->setCancellerRoles($user->getRoles());
        
                if($booking->getBooker()){
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
                }
        $entityManager->flush();

        $this->addFlash('danger', 'Le rendez vous à bien été supprimé');
        return $this->redirectToRoute('admin_calendar', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/calendar", name="admin_calendar", methods={"POST", "GET"})
     * @isGranted("ROLE_MANAGER", message="Vous n'avez pas accès à cette section.")
     */
    public function adminShowCalendar(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, SalonRepository $salonRepository , CoiffeurRepository $coiffeurRepository): Response
    {
        // On prend l'utilisateur connecté
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        //dd($user);


        $booking = new Booking();
        $form = $this->createForm(PhoneBookingType::class, $booking);
        $form->handleRequest($request);
        if ($this->isGranted('ROLE_ADMIN')){
            $salon = $salonRepository->findAll();
            $coiffeurs = $coiffeurRepository->findAll();
        }else{
            $salon = $salonRepository->findOneBy(['manager' => $user->getId()]);
            $coiffeurs = $coiffeurRepository->findBySalon($salon);
        }

        if ($form->isSubmitted() && $form->isValid()) {


            $startAt = $booking->getBeginAt()->format('Y-m-d H:i');
            $endAt = new DateTime($startAt);
            $endAt->modify('+ 30 minutes');
            
            
            $booking->setEndAt($endAt)
                ->setSalon($booking->getCoiffeur()->getSalon())
                ->setBookerFullname($booking->getBookerFullname())
                ->setTitle(strtolower($booking->getBookerFullname()))
                ->setColor($booking->getCoiffeur()->getColor())
                ->setIsPhoneBooking(true);
          
            
            //dd($booking);
            
            if(!$booking->isBookable()){
                $this->addFlash('warning', 'Ce créneau est déjà pris' );
                
            }else{
                
                $entityManager->persist($booking);
                $entityManager->flush();

                $this->addFlash('success', 'Le rendez-vous est bien enregistré.');
                return $this->redirectToRoute('admin_calendar');
            }
        }

        return $this->renderForm('admin/booking/calendar.html.twig',[
            'coiffeurs' => $coiffeurs,
            'salon' => $salon,
            'form' => $form
        ]);
    }

    // Fin de gestion du planning
    
}
