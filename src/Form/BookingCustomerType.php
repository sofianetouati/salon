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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingCustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => true,
                'html5' => false,

            ])
            ->add('product', EntityType::class,[
                'class' => Product::class,
                'label' => 'Prestation',
                'group_by' => function(Product $product){
                    return ucwords($product->getCategory()->getName());
                },
                'choice_label' => function(Product $product){
                    return ucwords($product->getName()).' '.lcfirst($product->getDetail());
                        
                },
                'placeholder' => '-- Choisir --',
                'attr' => [
                    'class' => 'mb-3'
                ]
            ])
            
            ->add('coiffeur', EntityType::class, [
                'class' => Coiffeur::class,
                'placeholder' => '-- Votre coiffeur --',
                'choices' => $options['coiffeurs'],
                'choice_label' => function(Coiffeur $coiffeur){
                    return ucwords($coiffeur->getFirstname().' '.strtoupper($coiffeur->getLastname()));
                },
                'attr' => [
                    'class' => 'js-coiffeur mb-3',
                    'hidden' => true,
                    
                ]
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
