<?php

namespace App\Form;

use App\Entity\Search\SearchProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchProjectType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', ChoiceType::class, [
                'required' => false,
                'preferred_choices' => [''],
                'choice_value' => null,
                'attr' => ['class' => 'form-control col-lg-2', 'data-select' => 'true'],
                'choices' => [
                    'DIST' => 'DIST',
                    'DISTAUTOR' => 'DISTAUTOR',
                    'DISTSEL' => 'DISTSEL',
                    'DEVSPFIC' => 'DEVSPFIC',
                    'TV' => 'TV'
                ],
                'group_by' => function($choice, $key, $value) {
                    if (preg_match("/DEV/i", $choice, $match)) {
                        return 'DEV';
                    }
                    elseif (preg_match("/DIST/i", $choice, $match)) {
                        return 'DIST';
                    }
                    else {
                        return 'TV';
                    }                  
                },      
            ])
            
            ->add('year', ChoiceType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-1'],
                'choices' => [
                    ' ' => '',
                    '2021' => 2021,
                    '2020' => 2020
                ]  
            ])
            ->add('round', ChoiceType::class, [
                'required' => false,
                'choice_value' => null,
                'attr' => ['class' => 'form-control col-lg-1'],
                'choices' => [
                    ' ' => '',
                    '1' => 1,
                    '2' => 2
                ]
                
            ])
            ->add('status', ChoiceType::class, [
                'required' => false,
                'choice_value' => null,
                'attr' => ['class' => 'form-control col-lg-1'],
                'choices' => [
                    ' ' => '',
                    'Open' => 'Open',
                    'Closed' => 'Closed'
                ]
            ]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProject::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

}

?>