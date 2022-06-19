<?php

namespace App\Form;

use App\Entity\Rest;
use App\Entity\User;
use App\Entity\Coiffeur;
use App\Entity\RestReason;
use App\Repository\UserRepository;
use App\Repository\CoiffeurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Départ'
                ]
            ])
            ->add('endAt', DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Retour'
                ]
            ])
            ->add('coiffeur', EntityType::class, [
                'class' => Coiffeur::class,
                'placeholder' => '-- Coiffeur --',
                'choice_label' => function(Coiffeur $coiffeur){
                    return ucwords($coiffeur->getFirstname().' '.strtoupper($coiffeur->getLastname()));
                },
            ])
            ->add('restReason', EntityType::class, [
                'class' => RestReason::class,
                
                'placeholder' => '-- Raison --',
                'choice_label' => function(RestReason $restReason){
                    return ucwords($restReason->getName());
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rest::class,
        ]);
    }
}
