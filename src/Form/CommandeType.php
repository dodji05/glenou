<?php

namespace App\Form;

use App\Entity\AdresseLivraison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('adresse',EntityType::class,[
                'label'=>'Choissez votre adresse de livraison',
                'class'=>AdresseLivraison::class,
                'choices'=>$user->getAdresseLivraison(),
                'multiple'=>false,
                'expanded'=>true,
            ])
            ->add('paiement',ChoiceType::class,[
                'label'=>'Choissez votre methode de paiement',
                'choices' => [
                    'A la livraison' => 'PAL',
                    'Momo/Flooz' => 'Mobile',
                ]

                ,
                'multiple'=>false,
                'expanded'=>true,
            ])
//            ->add('submit',SubmitType::class,[
//                'label'=>'Valider ma commande'
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user'=>array()
        ]);
    }
}
