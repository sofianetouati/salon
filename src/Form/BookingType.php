<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Salon;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Coiffeur;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormEvent;
use App\Repository\CoiffeurRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => 'true',
                'html5' => false,
                'attr' => [
                    'class' => 'js-flatpicker'
                ]

            ])
            ->add('product', EntityType::class,[
                'class' => Product::class,
                'group_by' => function(Product $product){
                    return ucwords($product->getCategory()->getName());
                },
                'choice_label' => function(Product $product){
                    return ucwords($product->getName()).' '.lcfirst($product->getDetail());
                        
                },
                'placeholder' => '-- Prestation --',
            ])
        
            ->add('booker', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
                            ->setParameter('role', '"ROLE_CLIENT"')
                            ->orderBy('u.lastname','ASC');
                },
                'placeholder' => '-- Client --',
                'choice_label' => function(User $user){
                    return ucwords($user->getFirstname().' '.strtoupper($user->getLastname()));
                }
            ])
            
            ->add('coiffeur', EntityType::class, [
                'class' => Coiffeur::class,
                'placeholder' => '-- Coiffeur --',
                'choices' => $options['coiffeurs'],
                'choice_label' => function(Coiffeur $coiffeur){
                    return ucwords($coiffeur->getFirstname().' '.strtoupper($coiffeur->getLastname()));
                },
            ]);
            
            

        }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, array(
            'date' => $options['date']
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'coiffeurs' => array(),
            'date' => array(),
        ]);
    }
}
