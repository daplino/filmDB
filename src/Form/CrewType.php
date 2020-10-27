<?php

namespace App\Form;

use App\Entity\Crew;
use App\Entity\Role;
use App\Form\PersonType;
use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CrewType extends AbstractType
{
    private $authorization;
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
    $this->authorization = $authorizationChecker;
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('role', EntityType::class, [
                    'class'         => Role::class,
                    'choice_label'  => 'name',
                    'multiple'      => false,
                    'query_builder' => function(RoleRepository $repository){
                        return $repository->findByWork();
                    }
                
            ])
            ->add('points')
            ->add('person', PersonType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Crew::class,
        ]);
    }
}
