<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Salon;
use App\Entity\Coiffeur;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SalonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom du salon',
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse du salon',
                ],
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'js-masked-phone form-control js-masked-enabled',
                ],
            ])
            
            ->add('manager', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
                        ->setParameter('role', '"ROLE_MANAGER"');
                },
                'placeholder' => '-- Manager --',
                
            ])
            ->add('openAt', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
            ])
            ->add('closeAt', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
            ])
            ->add('isBookingOnline', CheckboxType::class,[
                'label' => 'Réservation en ligne ?',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salon::class,
        ]);
    }
}
