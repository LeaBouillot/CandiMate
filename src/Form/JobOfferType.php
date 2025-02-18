<?php

namespace App\Form;

use App\Entity\JobOffer;
use App\Enum\JobStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Url;

class JobOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du poste',
                'constraints' => [
                    new NotBlank(['message' => 'Le titre est obligatoire']),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex: Développeur Full Stack PHP'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Entreprise',
                'constraints' => [
                    new NotBlank(['message' => 'Le nom de l\'entreprise est obligatoire']),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Le nom de l\'entreprise ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex: Google'
                ]
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien de l\'offre',
                'required' => false,
                'default_protocol' => 'https',  // Ajout du protocole par défaut
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez entrer une URL valide',
                        'requireTld' => true  // Explicitement définir requireTld
                    ]),
                    new Length([
                        'max' => 120,
                        'maxMessage' => 'L\'URL ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'https://exemple.com/offre-emploi'
                ]
            ])
            ->add('location', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La localisation ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex: Paris'
                ]
            ])
            ->add('salary', TextType::class, [
                'label' => 'Salaire',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Le salaire ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex: 45-55k€'
                ]
            ])
            ->add('contactPerson', TextType::class, [
                'label' => 'Contact',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 120,
                        'maxMessage' => 'Le nom du contact ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex: John Doe'
                ]
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Email du contact',
                'required' => false,
                'constraints' => [
                    new Email(['message' => 'Veuillez entrer une adresse email valide']),
                    new Length([
                        'max' => 120,
                        'maxMessage' => 'L\'email ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'contact@entreprise.com'
                ]
            ])
            ->add('applicationDate', DateType::class, [
                'label' => 'Date de candidature',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(['message' => 'La date de candidature est obligatoire'])
                ],
                'data' => new \DateTime(),
            ])
            ->add('status', EnumType::class, [
                'class' => JobStatus::class,
                'label' => 'Statut',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le statut est obligatoire'])
                ],
                'choice_label' => fn (JobStatus $status) => $status->label(),
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500'
                ],
                'placeholder' => 'Choisir un statut'
            ])
           
        //     ->add('save', SubmitType::class, [
        //         'label' => 'Enregistrer',
        //         'attr' => [
        //             'class' => 'px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-blue-700'
        //         ],
        //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobOffer::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
