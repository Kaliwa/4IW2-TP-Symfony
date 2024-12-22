<?php
// src/Form/ChapterType.php
namespace App\Form;

use App\Entity\Chapter;
use App\Entity\Exercise;
use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChapterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Chapter Title',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Chapter Content',
                'required' => false,
            ])
            ->add('subjectID', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'name',
                'label' => 'Subject',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save chapter',
                'attr' => ['class' => 'btn btn-success'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chapter::class,
        ]);
    }
}
