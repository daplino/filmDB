<?php

namespace App\Form;

use App\Entity\Search\SearchWork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchWorkType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-9', 'data-select' => 'true']   
            ])
            ->add('id', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-1', 'data-select' => 'true']   
            ])
            ->add('year', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-1', 'data-select' => 'true']   
            ])
            ->add('nationality', ChoiceType::class, [
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
            ])
            ->add('director', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-9', 'data-select' => 'true']   
            ]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchWork::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

}

?>