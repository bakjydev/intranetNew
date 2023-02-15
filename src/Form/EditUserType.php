<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                            'message' => 'Merci de saisir une adresse email'
                        ])
                ],
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    'Admin simple'=>'ROLE_ADMIN',
                    'Admin RH'=>'ROLE_ADMINRH',
                    'Utilisateurs externe'=>'ROLE_USERSIMPLE',
                    'Utilisateurs non validé'=>'ROLE_USER',
                    'Bakjy member'=>'ROLE_BAKJY'
                ],
                'expanded'=>true,
                'multiple'=>true,
                'label'=>'Rôles'
            ])
            ->add('Prenom',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Nom',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Birthday',DateType::class)
            ->add('Valider',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary'

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
