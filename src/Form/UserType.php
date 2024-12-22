<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image as AssertImage;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ])
            ->add('classeID', EntityType::class, [
                'label' => 'Classe',
                'class' => Classroom::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Role',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Banni' => 'ROLE_BANNED',
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'flex flex-col mt-2 p-3 border border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ])
            ->add('profileImage', FileType::class, [
                'label' => 'Image de profil',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new AssertImage([
                        'maxSize' => '5M',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'py-3 px-6 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mt-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
