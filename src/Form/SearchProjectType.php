<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\Search\SearchProject;
use App\Repository\ActionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchProjectType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', EntityType::class, array(
                'class' => Action::class,
                'choice_label'  => 'code',
                'data' => 'DISTAUTOG',
                'attr' => ['class' => 'form-control col-lg-2'],
                'query_builder' => function (ActionRepository $actionRepository) {
                        return $actionRepository->createQueryBuilder('a');
                    }
                ))
                            
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