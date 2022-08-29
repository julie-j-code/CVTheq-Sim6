<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $builder
                ->add(
                    'fullName',
                    TextType::class,
                    [
                        'attr' => [
                            'class' => 'form-control',
                            'minlenght' => '2',
                            'maxlenght' => '50',
                        ],
                        'label' => 'Nom / Prénom',
                        'label_attr' => [
                            'class' => 'form-label  mt-4'
                        ]
                    ]
                )
                ->add(
                    'email',
                    EmailType::class,
                    [
                        'attr' => [
                            'class' => 'form-control',
                            'minlenght' => '2',
                            'maxlenght' => '180'
                        
                        ],
                        'label' => 'Adresse email',
                        'label_attr' => [
                            'class' => 'form-label  mt-4'
                        ]
                    ]
                )
                ->add('subject', TextType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'minlenght' => '2',
                        'maxlenght' => '100',
                    ],
                    'label' => 'Sujet',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ]
                ])
                ->add('message', TextType::class, [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Description',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ])
    
                ->add('submit', SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-primary mt-4'
                    ],
                    'label' => 'Contacter le candidat'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
