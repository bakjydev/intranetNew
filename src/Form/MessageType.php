<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                "label" => "Titre",
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
            ->add('typecp', ChoiceType::class, [
                "label" => "Type de congés",
                "attr"=>[
                    "class"=>"form-select"
                ],
                'choices'  => [
                    'RTT' => 'RTT',
                    'Congés payés' => 'Congés payés',
                    'Maladie' => 'Maladie',
                    'Sans solde' => 'Sans solde',
                    'Congés exceptionnels (Mariage, décès ...)' => 'Congés exceptionnels (Mariage, décès ...)',
                ]
            ])
            ->add('start',DateTimeType::class, [
                'date_widget'=>'single_text',
                "label" => "Début",
                "attr"=>[
                    "class"=>"datepicker"
                ]
            ])
            ->add('end',DateTimeType::class, [
                'date_widget'=>'single_text',
                "label" => "Fin",
                "attr"=>[
                    "class"=>"datepicker"
                ]
            ])
            ->add('message', TextareaType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
            ->add('recipient', EntityType::class, [
                "class" => User::class,
                "label" => "Destinataire",
                "choice_label" => "email",
                    "attr"=>[
                        "class"=>"form-control"
                    ],
            ])
            ->add('envoyer', SubmitType::class, [
                "attr"=>[
                    "class"=>"btn btn-primary mt-5"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
