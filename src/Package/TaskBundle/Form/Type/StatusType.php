<?php

namespace Package\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Name'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Description',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array('label' => 'Submit'));
    }
}