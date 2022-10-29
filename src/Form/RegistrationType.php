<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use function Sodium\add;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Enter your mail address here'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            //->add('roles')
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                //  we get the user (the form data)
                $user = $event->getData();
                // and the form, since we are in an anonymous function
                $form = $event->getForm();

                // Are we editing or adding?
                if(is_null($user->getId())) {
                    // null ID -> adding a user

                    // add the password field configured for adding
                    $form->add('password', RepeatedType::class, [
                        'constraints' => [
                            new NotBlank(),
                            new Regex("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", "Your password does not respect security rules.")
                        ],
                        'type' => PasswordType::class,
                        'invalid_message' => 'The two passwords must be identical!',
                        'first_options'  => [
                            'label' => 'Password',
                            'help' => 'At least 8 characters, including a letter, a number and a special character.'
                        ],
                        'second_options' => ['label' => 'Repeat your password'],
                    ]);

                } else {
                    // Non-null ID -> modification of an existing user

                    // add the password field configured for the modification
                    $form->add('password', RepeatedType::class, [
                        'constraints' => new Regex("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", "Your password does not respect security rules."),
                        'type' => PasswordType::class,
                        'invalid_message' => 'The two passwords must be identical!',
                        'first_options'  => [
                            'label' => 'Password',
                            'help' => 'Leave blank if unchanged.'
                        ],
                        'second_options' => ['label' => 'Repeat your password'],
                    ]);
                }
            })

            //->add('createdAt')
            //->add('updatedAt')
            ->add('profile', ProfileType::class)
            ->add('captcha', ReCaptchaType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
