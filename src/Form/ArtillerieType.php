<?php

namespace App\Form;

use App\Entity\Artillerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ArtillerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' =>  'Nom',
                'attr' => [
                    'placeholder' => 'Nom de l\'Artillerie'
                ],
                'required' => true,
            ])
            ->add('tier', NumberType::class, [
                'label' => 'Tier',
                'attr' => [
                    'placeholder' => 'tier de l\'Artillerie'
                ],
                'required' => true,
            ])
            ->add('poids', NumberType::class, [
                'label' => 'poids',
                'attr' => [
                    'placeholder' => 'Poids de l\'Artillerie'
                ],
                'required' => true,
            ])
            ->add('image', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'asset_helper' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artillerie::class,
        ]);
    }
}
