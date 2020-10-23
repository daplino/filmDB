<?php

namespace App\Form;

use App\Entity\Work;
use App\Entity\Genre;
use App\Entity\Audience;
use App\Form\ProductionType;
use App\Repository\WorkRepository;
use App\Repository\GenreRepository;
use App\Repository\AudienceRepository;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class WorkType extends AbstractType
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $workType = $options['workType'];

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
            ->add('audience', EntityType::class, [
                
                'class'         => Audience::class,
                'choice_label'  => 'name',
                'multiple'      => false,
                'query_builder' => function(AudienceRepository $repository) use ( $workType ){
                    return $repository->findByWork($workType);
                }
            ])
            ->add('genres', EntityType::class, [
                'class'         => Genre::class,
                'choice_label'  => 'name',
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function(GenreRepository $repository) use ( $workType ){
                    return $repository->findByWork($workType);
                }
                
            ])
            ->add( 
                'production', CollectionType::class, [
                'entry_type' => ProductionType::class,
                'entry_options' =>[
                    'label'=> false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
                ]   
            ) 

            
                
            ;
            
            /*$builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
            $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));*/
            
            //Gestion de l'insertion des champs des classes  
            //film/jeu video en fonction du type d'oeuvre
            switch($workType){
                case 'Film':
                $builder->add('bar', FilmType::class,[
                    'data_class' => Work::class,
                ]);
                break;

                case "VideoGame":
                $builder->add('bar', VideoGameType::class,[
                    'data_class' => Work::class,
                ]);
                break;
            }
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Work::class,
            'workType' => null,
        ]);
    }


}
