<?php

namespace App\Form;

use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Pseudo', TextType::class, [
                'label' => 'Pseudo',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Pseudo',
                ]
            ])
            ->add('Discord', TextType::class, [
                'label' => 'Discord',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Discord',
                ]
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Email@email.com',
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => false,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'S3CR3T',
                    ],
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                            'message' => 'Votre mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                        ]),
                        new Assert\NotBlank(),
                        new Assert\Length(
                            max: 4096,
                        ),
                    ],
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                    'attr' => [
                        'placeholder' => 'S3CR3T'
                    ],
                ],
            ]);
        if ($options['isAdmin']) {
            $builder->remove('password')
                ->add('roles', ChoiceType::class, [
                    'label' => 'Rôles',
                    'choices' => [
                        'Administrateur' => 'ROLE_ADMIN',
                        'Officier' => 'ROLE_OFFI',
                        'Joueur' => 'ROLE_JOUEUR',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                ]);
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
            'isAdmin' => false,
        ]);
    }
}
