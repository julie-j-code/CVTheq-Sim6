<?php

namespace App\Form;

use App\Entity\Todos;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('content')
           // si c'est le super admin qui gère l'affectation des tâches
           //    faudra juste conditionner l'accès au lien d'ajout depuis le template...
            ->add('user', EntityType::class, [
                'expanded'=>true,
                'class'=>Users::class,
                'multiple'=>false,
                'query_builder'=>function(UsersRepository $repo){
                    return $repo->createQueryBuilder('u')
                    ->orderBy('u.email', 'ASC');
                }
            ])
            ->add('edit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todos::class,
        ]);
    }
}
