<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'placeholder' => 'Nom de la prestation'
                ]
            ])
            ->add('detail', TextType::class,[
                'attr' => [
                    'placeholder' => 'Description facultative'
                ]
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => function(Category $category){
                    return strtoupper($category->getName());
                },
                'placeholder' => '-- Catégorie --',
                
            ])
            ->add('price',MoneyType::class,[
                'attr' => [
                    'placeholder' => 'Prix'
                ],
                'divisor' => 100,
                'scale' => 2
                
            ])
            ->add('duration', DateIntervalType::class, [
                'attr' => [
                    'class' => "row"
                ],
                'hours' => range(0, 3),
                'minutes' => range(0, 60),
                'with_hours' => true,
                'with_minutes' => true,
                'with_years' => false,
                'with_months' => false,
                'with_days' => false,
                'labels' => [
                    'hours' => 'Heures',
                    'minutes' => 'Minutes',
                ]
            ])
            
            ->add('published', CheckboxType::class,[
                'label' => 'Visible sur le site web ?',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
