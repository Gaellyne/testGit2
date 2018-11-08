<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class AdresseType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('adresse1', TextType::class)
                ->add('adresse2', TextType::class)
                ->add('codepostal', TextType::class)
                ->add('ville', TextType::class)
                ->add('save', SubmitType::class, ['label' => 'Ajouter une adresse']);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
        'data_class' => Adresse::class
        ]);
    }
}
