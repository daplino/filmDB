<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends WorkType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('length')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
            'inherit_data' => true,
        ]);
    }
}
