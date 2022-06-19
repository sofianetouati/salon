<?php

namespace App\Form;

use App\Entity\ContactForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom.',
                    ],
                'required' => true
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez votre email.',
                    ],
                'required' => true
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message',
                'attr' =>[
                    'placeholder' => 'Posez Votre Question Ici.',
                    'row' => '5'],
                'required' => true
            ])
            ->add('isGrpd', CheckboxType::class,[
                'label' => 'En soumettant ce formulaire j\'accepte qu\'Elite Barber Shop utilise mes coordonnées dans le strict cadre de la réponse à ma demande.',
                'attr' =>[
                    'class' => 'checkbox-inline'
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
            
        ]);
    }
}
