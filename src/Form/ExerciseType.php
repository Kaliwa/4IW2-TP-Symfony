<?php

namespace App\Form;

use App\Entity\Exercise;
use App\Entity\Chapter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextareaType::class)
            ->add('response', TextareaType::class)
            ->add('chapterID', EntityType::class, [   // Correction ici : 'chapter' au lieu de 'chapterID'
                'class' => Chapter::class,
                'choice_label' => 'title',
                'label' => 'Chapter',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save exercise',
                'attr' => ['class' => 'btn btn-success'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
