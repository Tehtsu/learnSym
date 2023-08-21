<?php

namespace App\Form\Type;

use App\Entity\GuestBookEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestBookType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class,['empty_data' => '']);
        $builder->add('email', TextType::class,['required' => false]);
        $builder->add('subtitle', TextType::class,['empty_data' => '']);
        $builder->add('body', TextType::class,['empty_data' => '']);
        $builder->add('submit', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GuestBookEntity::class,
            'csrf_protection' => true
        ]);
    }
}
