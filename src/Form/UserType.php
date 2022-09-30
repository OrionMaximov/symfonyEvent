<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('nom')
            ->add('prenom')
            ->add('email',EmailType::class)
            //->add('roles')
            ->add('password',PasswordType::class)
            ->add('confirmPassword',PasswordType::class)
            ->add('date',DateType::class, ['label'=>'date m/d/Y','widget'=>'single_text'])
            ->add('avatar',FileType::class)
            ->add('genre',ChoiceType::class,[
                'choices'=>[
                    'Femme'=>"femme",
                    'Homme'=> 'homme'
                ]
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
