<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Profile1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class)
            ->add('pseudo', TextType::class)
            ->add('bio', TextareaType::class)
            //->add('profilePicture')
            ->add('birthDate',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => false
                ])
            //->add('updatedAt')
            //->add('slug')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => "email",
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
