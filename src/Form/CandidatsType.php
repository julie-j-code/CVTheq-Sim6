<?php

namespace App\Form;

use App\Entity\Hobbies;
use App\Entity\Profiles;
use App\Entity\Candidats;
use Doctrine\ORM\EntityRepository;
use App\Repository\HobbiesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
