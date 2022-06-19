<?php

namespace App\EventSubscriber;

use CalendarBundle\Entity\Event;
use App\Repository\RestRepository;
use App\Repository\UserRepository;
use CalendarBundle\CalendarEvents;
use App\Repository\SalonRepository;
use App\Repository\BookingRepository;
use App\Repository\CoiffeurRepository;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarSubscriber extends AbstractController implements  EventSubscriberInterface  
{
    private $bookingRepository;
    private $router;
    private $restRepository;
    private $salonRepository;
    private $userRepository;
    private $coiffeurRepository;
    
    
    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router,
        RestRepository $restRepository,
        SalonRepository $salonRepository,
        UserRepository $userRepository,
        CoiffeurRepository $coiffeurRepository
        
        ) {
            $this->bookingRepository = $bookingRepository;
            $this->router = $router;           
            $this->restRepository = $restRepository; 
            $this->salonRepository = $salonRepository; 
            $this->userRepository = $userRepository; 
            $this->coiffeurRepository = $coiffeurRepository; 
        }
        
        /**
         * Undocumented function
         *
         * @return array
         */
        public static function getSubscribedEvents()
        {
            return [
                CalendarEvents::SET_DATA => 'onCalendarSetData',
            ];
        }
        
        public function onCalendarSetData(CalendarEvent $calendar)
        {
            $start = $calendar->getStart();
            $end = $calendar->getEnd();
            
            $filters = $calendar->getFilters();
            
            
            // Modify the query to fit to your entity and needs
            // Change booking.beginAt by your start date property
            $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->andWhere('booking.isCancel = 0')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
            ;
            
            $rests = $this->restRepository
            ->createQueryBuilder('rest')
            ->where('rest.startAt BETWEEN :start and :end OR rest.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
            ;
            
            
            
            $user = $this->userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
            $salon = $this->salonRepository->findOneBy(['manager' => $user]);
            if ($this->isGranted('ROLE_ADMIN')) {
                $coiffeurs = $this->coiffeurRepository->findAll();
            }else{

                $coiffeurs = $salon->getCoiffeurs();
            }
            

            foreach ($bookings as $booking) {
                // this create the events with your data (here booking data) to fill calendar
                $bookingEvent = new Event(
                    ucwords($booking->getTitle()),
                    $booking->getBeginAt(),
                    $booking->getEndAt(), // If the end date is null or not defined, a all day event is created.
                );
                
            
                $bookingEvent->setOptions([
                    'backgroundColor' => $booking->getColor(),
                    'borderColor' => $booking->getColor(),
                ]);

                $bookingEvent->addOption(
                    'url',
                    $this->router->generate('admin_booking_show', [
                        'id' => $booking->getId()
                    ])
                );
                if ($this->isGranted('ROLE_ADMIN') || $salon === $booking->getSalon()) {
                    $calendar->addEvent($bookingEvent);
                }
            }


            foreach ($rests as $rest) {
                // this create the events with your data (here booking data) to fill calendar
                    $restEvent = new Event(
                        ucwords($rest->getRestReason()->getName()),
                        $rest->getStartAt(),
                        $rest->getEndAt()
                        // If the end date is null or not defined, a all day event is created.
                    );


                /*
                * Add custom options to events
                *
                * For more information see: https://fullcalendar.io/docs/event-object
                * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
                */


                $restEvent->setOptions([
                    'backgroundColor' => $rest->getCoiffeur()->getColor(),
                    'borderColor' => $rest->getCoiffeur()->getColor(),
                    'allDay' => true

                    
                ]);

                $restEvent->addOption(
                    'url',
                    $this->router->generate('admin_coiffeur_show', [
                        'id' => $rest->getCoiffeur()->getId()
                    ])
                );

                // finally, add the rest to the CalendarEvent to fill the calendar

                foreach ($coiffeurs as $coiffeur ) {
                    if($this->isGranted('ROLE_ADMIN') || $rest->getCoiffeur() === $coiffeur){
                        $calendar->addEvent($restEvent);
                    }
                }

                
            }
        }
        
}