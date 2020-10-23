<?php

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GenreType extends AbstractType {

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /*$builder
            ->addModelTransformer(new ElementObjToStringTransformer($this->em))
        ;*/
    }

    public function getParent() {
        return 'text';
    }

    public function getName() {
        return 'elementCustom';
    }
}

?>