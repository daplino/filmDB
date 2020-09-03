<?php

namespace App\Form;

use App\Entity\Work;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class WorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('yearOfCopyright')
            ->add( 
                'crew', CollectionType::class, [
                'entry_type' => CrewType::class,
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
            'data_class' => Work::class,
        ]);
    }
}
