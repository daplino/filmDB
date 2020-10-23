<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Production;
use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('share')
            ->add('company', CompanyType::class)
            ->add('role', EntityType::class, [
                'class'         => Role::class,
                'choice_label'  => 'name',
                
                'multiple'      => false,
                'query_builder' => function(RoleRepository $repository){
                    return $repository->findByWork();
                }
            
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Production::class,
        ]);
    }
}
