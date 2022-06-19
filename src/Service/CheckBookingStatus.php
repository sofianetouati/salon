<?php
namespace App\Service;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\SalonRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;

use const App\Entity\STATUS_FINISHED;
use const App\Entity\STATUS_WAITING;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckBookingStatus extends AbstractController
{
    private $bookingRepository;
    private $salonRepository;
    private $userRepository;
    private $em;

    public function __construct(EntityManagerInterface $em, BookingRepository $bookingRepository, SalonRepository $salonRepository, UserRepository $userRepository){

        $this->bookingRepository = $bookingRepository;
        $this->salonRepository = $salonRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }


        public function checkBookingStatus()
        {

            $now = new DateTime();  
            $bookings = $this->bookingRepository->findAll();
            foreach ($bookings as $booking) {

                $endAt = $booking->getEndAt();

                if($now > $endAt && $booking->getIsCancel() == 0){
                    $booking->setStatus(STATUS_FINISHED);
                }elseif($now < $endAt && $booking->getIsCancel() == 0){
                    $booking->setStatus(STATUS_WAITING);
                }
            }
            $this->em->flush();
            return $bookings;
        }

        public function checkSalonBookingStatus()
        {
            $now = new DateTime();  
            $salons = $this->salonRepository->findAll();
            foreach ($salons as $salon) {
                foreach ($salon->getBookings() as $booking) {
                    # code...
                    $endAt = $booking->getEndAt();
                    if($now > $endAt && $booking->getStatus() !== 'danger'){
                        $booking->setStatus(STATUS_FINISHED);
                    }
                }
            }
            $this->em->flush();
            return $salons;
        }

        public function checkCustomerBookingStatus($id)
        {
            $now = new DateTime();  
            $user = $this->userRepository->find($id);

                foreach ($user->getBookings() as $booking) {
                    
                    $endAt = $booking->getEndAt();
                    if($now > $endAt && $booking->getStatus() !== 'danger'){
                        $booking->setStatus(STATUS_FINISHED);
                    }

                }
            $this->em->flush();
            return $user;
        }
}
