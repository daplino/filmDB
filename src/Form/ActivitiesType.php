<?php

namespace App\Form;

use App\Entity\Project;

use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ActivitiesType extends AbstractType
{
    

    protected $activities;

    public function __construct(){

        
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add(
                'activities',
                CollectionType::class,
                
                [
                
                'entry_type' => ActivityType::class,
                'entry_options' =>[
                    'label'=> false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
                ]   
            );
            
       
    }
        
       
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'activities' => null,
        ]);
    }
}
