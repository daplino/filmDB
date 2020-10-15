<?php

namespace App\Form;

use App\Entity\Search\SearchProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchProjectType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', TextType::class, [
                'required' => false
                
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