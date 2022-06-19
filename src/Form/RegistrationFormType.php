<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class'        => 'form-control form-control-lg form-control-alt',
                    'placeholder'  => 'Entrez votre prénom',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom'])
                ],
            ])

            ->add('lastname', TextType::class, [
                'attr' => [
                    'class'        => 'form-control form-control-lg form-control-alt',
                    'placeholder'  => 'Entrez votre nom',
                ] ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom'])
                ],
            ])

            ->add('phone', TelType::class,[
                'attr' => [
                    'autocomplete' => 'phone',
                    'class'        => 'form-control form-control-lg form-control-alt js-masked-phone js-masked-enabled',
                    'placeholder'  => 'Entrez votre numéro de téléphone',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre numéro de téléphone']),
                        new Length([
                            'min' => 10,
                            'max' => 10,
                            'exactMessage' => 'Votre numéro de téléphone doit contenir {{ limit }} chiffres',
                        ]),
                    ],
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'placeholder' => 'Email',
                    'class' => 'form-control form-control-lg form-control-alt',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre email'])
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation.',
                    ]),
                ],
                'label' => 'J\'accepte les conditions d\'utilisations'
            ])

            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class'        => 'form-control form-control-lg form-control-alt',
                    'placeholder'  => 'Choisissez un mot de passe',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre mot de passe ne peut pas être vide',
                        ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                        ]),
                    ],
                ]);
            }
            
            public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    'data_class' => User::class,
                ]);
    }
}
