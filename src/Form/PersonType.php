<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control col-lg-1'],
                'choices' => [
                    ' ' => '',
                    'M' => 'M',
                    'F' => 'F'
            ]])
            ->add('nationality',TextType::class, [
                'empty_data' => ''
            ])
            ->add('residence',TextType::class, [
                'empty_data' => ''
            ])
            ->add('firstName')
            ->add('lastName')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
