<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('action')
            ->add('year')
            ->add('round')
            ->add( 
                'activities', CollectionType::class, [
                'entry_type' => ActivityType::class,
                'entry_options' =>[
                    'label'=> false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
                ]   
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
