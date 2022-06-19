<?php

namespace App\Controller\Home;

use Facebook\Facebook;
use App\Form\ContactType;
use App\Entity\ContactForm;
use Symfony\Component\Mime\Email;
use App\Repository\SalonRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Facebook\Exceptions\FacebookSDKException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Facebook\Exceptions\FacebookResponseException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $productRepository, SalonRepository $salonRepository, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
           
        $contact = new ContactForm;
        $form = $this->createForm(ContactType::class, $contact);
        

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $email = (new TemplatedEmail())
            
                ->priority(Email::PRIORITY_HIGH) 
                ->subject('Nouveau message de votre site')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'message' => $contact
                ]);
        

                $mailer->send($email);
            
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Votre message à bien été envoyé.');
            return $this->redirectToRoute('homepage');
        }
        
        $formView = $form->createView();

        //Salons
        $salons = $salonRepository->findAll();
        
        $capability = '';
        foreach($salons as $salon) {
            if($salon->getIsBookingOnline() == true){
                $capability = 'Réservation en ligne !';
            }else{
                $capability = 'Uniquement par téléphone';
            }
        }


        $categories = $categoryRepository->findAll();

        foreach ($categories as $category) {
            foreach ($category->getProducts() as $product) {
                $product->setPrice($product->getPrice()/100);
            }
        }

        $lowestProduct = $productRepository->findOneBy([],["price"=>"ASC"]);
        $price = $lowestProduct->getPrice();
        
        $fb = new \Facebook\Facebook([
            'app_id' => $this->getParameter('app.fb_id'),
            'app_secret' => $this->getParameter('app.fb_secret'),
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
          ]);


        return $this->render('home/index.html.twig',[
            'contact' => $contact,
            'form' => $formView,
            'salons' => $salons,
            'categories' => $categories,
            'price' => $price,
            'capability' => $capability
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
     public function showMentions(): Response
     {
         return $this->render('home/mentions.html.twig');
     }

}
