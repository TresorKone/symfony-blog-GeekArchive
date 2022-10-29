<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'User Roles',
                'choices' => [
                    'User' => "ROLE_USER",
                    'Admin' => "ROLE_ADMIN"
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password', TextType::class)
            //->add('createdAt')
            //->add('updatedAt')
            //->add('profile')
            ->add('temporalyBan',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
