<?php

namespace App\Form;

use App\Entity\Salon;
use App\Entity\Coiffeur;
use App\Repository\SalonRepository;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CoiffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('jobStartAt', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',

            ])

            ->add('jobEndAt', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',
            ])
            
            ->add('Salon', EntityType::class,[
                'class' => Salon::class,
                'query_builder' => function (SalonRepository $er) {
                    return $er->createQueryBuilder('s')
                            ->orderBy('s.name','ASC');
                },
                'choice_label' => function(Salon $salon){
                    return ucwords($salon->getName());
                },
                'placeholder' => '-- Salon --',
            ])

            ->add('color', TextType::class, [
                'attr' =>[
                    'placeholder' => 'Choisir une couleur',
                ],
            ])
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, array(
            'start' => $options['start'],
            'stop' => $options['stop'],
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coiffeur::class,
            'start' => array(),
            'stop' => array(),
        ]);
    }
}
