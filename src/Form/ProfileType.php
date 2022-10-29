<?php

namespace App\Form;

use App\Entity\Profile;

use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname')
            ->add('pseudo')
            ->add('bio')
            //->add('profilePicture')
            ->add(
                'birthDate',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => false,
                    'empty_data' => ''
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
