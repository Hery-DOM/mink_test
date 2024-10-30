<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Breed;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('birthdate', null, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('status',ChoiceType::class,[
                "choices" => [
                    "En vente" => "on_sale",
                    "Vendu" => "sold"
                ]
            ])
            ->add('is_published')
            ->add('price_ht')
            ->add('tva', NumberType::class,[
                "data" => "0.20"
            ])
            ->add('breed', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name',
                'group_by' => 'type.name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class
        ]);
    }
}
