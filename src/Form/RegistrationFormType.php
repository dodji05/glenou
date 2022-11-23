<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    protected $cart;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->cart = $options['cart'];
        $builder
            ->add('nom', TextType::class, [
//                'attr'=>[
//                    'class'=>'form-control'
//                ]
            ])
            ->add('prenom', TextType::class)
          /*  ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculim' => 'M',
                    'Feminin' => 'F',

                ]]);*/
        ;
        if ($this->cart == false) {
            $builder
                /*->add('secteurActivite', ChoiceType::class, [
                    'choices' => [
                        'Producteur' => 'producteur',
                        'Transformateur' => 'tranformateur',

                    ]])*/
                ->add('adresse', TextType::class);

        };
        $builder
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', TextType::class)
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'cart' => false,
        ]);
        $resolver->setAllowedTypes('cart', 'boolean');
    }
}
