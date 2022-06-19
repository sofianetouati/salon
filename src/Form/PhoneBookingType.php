<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Coiffeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PhoneBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => true,
                'html5' => false,

            ])
            ->add('bookerFullname', TextType::class,[
                'label' => 'Nom du client',
                'attr' => [
                    'placeholder' => 'Nom du client'
                ],
            ])
            ->add('productName', TextType::class,[
                'label' => 'Entrez une prestation',
                'attr' => [
                    'placeholder' => 'Entrez une prestation'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Observation',
                'attr' => [
                    'placeholder' => 'Observations'
                ]
            ])
            ->add('coiffeur', EntityType::class, [
                'class' => Coiffeur::class,
                'placeholder' => '-- Coiffeur --',
                'choice_label' => function(Coiffeur $coiffeur){
                    return ucwords($coiffeur->getFirstname().' '.strtoupper($coiffeur->getLastname()));
                },
            ]);
            //->add('Salon')
            //->add('color')
            //->add('bookerEmail')
            //->add('productName')
            //->add('bookerPhone')
            //->add('status')
            //->add('productPrice')
            //->add('productDetail')
            //->add('productDuration')
            //->add('booker')
            //->add('product')
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
