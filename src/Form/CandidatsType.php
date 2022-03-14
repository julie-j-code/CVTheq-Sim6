<?php

namespace App\Form;

use App\Entity\Hobbies;
use App\Entity\Profiles;
use App\Entity\Candidats;
use App\Repository\HobbiesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class CandidatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('age')
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('profiles', EntityType::class,[
                'expanded'=>true,
                'required' => false,
                'class'=>Profiles::class, 
                'multiple'=>false,
            ])
            ->add('hobbies', EntityType::class, [
                'expanded'=>true,
                'class'=>Hobbies::class,
                'multiple'=>true,
                'query_builder'=>function(HobbiesRepository $repo){
                    return $repo->createQueryBuilder('h')
                    ->orderBy('h.designation', 'ASC');
                }
            ])
            ->add('jobs')

             // upload d'image
             ->add('picture', FileType::class, [
                'label' => 'Photo de profile Candidat (jpeg de préférence)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/JPG',
                            'image/pgn',
                            
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG or PNG image',
                    ])
                ],
            ])
            // ... fin de l'upload
            ->add('editer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidats::class,
        ]);
    }
}
