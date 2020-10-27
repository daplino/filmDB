<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\Project;
use App\Entity\Activity;
use App\Repository\ActionRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('action', EntityType::class, array(
                'class' => Action::class,
                'choice_label'  => 'code',
                'data' => 'DISTAUTOG',
                'query_builder' => function (ActionRepository $actionRepository) {
                        return $actionRepository->createQueryBuilder('a');
                    },
            ))
            ->add('year', DateType::class, array(
             'years'           => range(date('Y')+1, date('Y')-15),   
            ))
            ->add('round')
            ->add('status')
            ->add(
                'activities',
                CollectionType::class,
                
                [
                'auto_initialize' => false,
                'entry_type' => ActivityType::class,
                'entry_options' =>[
                    'label'=> false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
                ]   
            );
            
        $builder
            ->get('action')->addEventListener(
                FormEvents::POST_SUBMIT,
               
                function (FormEvent $event){ 
                    $form = $event->getForm();  
                    /*$this->addActivitiesTable($form->getParent(), $form->getData());*/
                    $form->getParent()->remove('activities')
                        ->add(
                        'activities',
                        CollectionType::class,
                        [
                        'auto_initialize' => false,
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

            );
    }
        
        /*$builder->addEventListener(
           FormEvents::POST_SET_DATA,
           function (FormEvent $event){
               $data = $event->getData();
               $activities = $data->getActivities();
               
           } 
        );
    }
    /**
     * Ajout de la table des activités
     * @param FormInterface $form
     * @param Action $action
     */
private function addActivitiesTable(FormInterface $form, Action $action) {
        /*$form->remove('activities');*/
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'activities',
                CollectionType::class,
                null, 
                [
                'auto_initialize' => false,
                'entry_type' => ActivityType::class,
                'entry_options' =>[
                    'label'=> false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
                ]   
            );
            $form->add($builder->getForm());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
