<?php

namespace App\Form;

use App\Entity\CategorieProduits;
use App\Entity\Categories;
use App\Entity\Produit;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,$this->getConfiguration("Nom du produit", "Entrez le nom du produit ",  ['required' => true]))
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control'
                ],

            ])
            ->add('description',TextareaType::class,$this->getConfiguration("Description", "Entrez la description du produit ",  ['required' => true]))
            ->add('disponibilite', ChoiceType::class, [
                'choices' => [
                    'Immédiatement' => 0,
                    'Sur commande' => 'sur-commande',
                    'Dans une semaine' => 7,
                    'Dans deux semaines' => 15,
                    'Dans un mois' => 30,
                    'Dans trois mois' => 90,
                    'Dans six mois' => 180,
                    'Autre' => 'Autres'],
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Selectionnez la disponibilité du produit',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('uniteMesure', ChoiceType::class,[
                'choices' => [
                    'Unites'=>'unite',
                    'Kilogrammes'=>'kg',
                    'Litres'=>'L'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Selectionnez l\'unité de mesure du produit',
                'expanded' => false,
                'multiple' => false,
                'help'=>'Litre pour produits liquide, Kg pour produits solides, unite pour produits de miche'
            ])
            ->add('prix',IntegerType::class,$this->getConfiguration("Prix", "Entrez le prix du produit ",  ['required' => true]))
            ->add('stock',IntegerType::class,$this->getConfiguration("Quantite", "Entrez la quantite que vous voulez mettre en vente ",  ['required' => true]))
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('localite',TextType::class,$this->getConfiguration("Localite", "Entrez la localite ou se trouve le produit ",  ['required' => true]));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
