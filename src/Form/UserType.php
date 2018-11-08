<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstname', TextType::class)
                ->add('lastname', TextType::class)
                ->add('email', TextType::class)
                ->add('phone', TextType::class)
                ->add('groupe', EntityType::class, array(
                'class' => Groupe::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.label', 'ASC');
                    },
                    'choice_label' => 'label',
                ))
                ->add('adresses', EntityType::class, array(
                    'class' => Adresse::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.adresse1', 'ASC');
                    },
                    'choice_label' => 'adresse1',
                    'multiple' => true,
                ))
                ->add('save', SubmitType::class, ['label' => 'Ajouter un user']);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
        'data_class' => User::class
        ]);
    }
}
