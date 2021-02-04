<?php

namespace App\Form;

use App\Entity\Association;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\EventDates;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'row_attr' => ['class' => 'mb-2'],
                'label' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Title text here']
            ])
            ->add('description', TextareaType::class, [
                'row_attr' => ['class' => 'mb-2'],
                'label' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Event description here']
            ])
            ->add('venue', TextType::class, [
                'row_attr' => ['class' => 'mb-2'],
                'label' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Venue details here']
            ])
            ->add('category', EntityType::class, [
                'row_attr' => ['class' => 'mb-2'],
                'label' => false,
                'class' => Category::class, 'placeholder' => 'category',
                'attr' => ['class' => 'form-control']
            ])
            // ->add('startDate', DateType::class, [
            //     'row_attr' => ['class' => 'col-6 mb-3'],
            //     'attr' => ['class' => 'form-control'],
            //     'widget' => 'single_text',
            // ])
            // ->add('endDate', DateType::class, [
            //     'row_attr' => ['class' => 'col-6 mb-3'],
            //     'attr' => ['class' => 'form-control'],
            //     'widget' => 'single_text',
            // ])
            // ->add('featuredImage', FileType::class, [
            //     'label' => 'Featured Image',
            //     'row_attr' => ['class' => 'col-12 mb-3'],
            //     'attr' => ['class' => 'form-control'],

            //     // unmapped means that this field is not associated to any entity property
            //     'mapped' => false,

            //     // make it optional so you don't have to re-upload the PDF file
            //     // every time you edit the Product details
            //     'required' => false,

            //     // unmapped fields can't define their validation using annotations
            //     // in the associated entity, so you can use the PHP constraint classes
            //     'constraints' => [
            //         new File([
            //             'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/png',
            //             ],
            //             'mimeTypesMessage' => 'Please upload a valid image file (805 x 450 pixels)',
            //         ])
            //     ],
            // ])
            // ->add('association', EntityType::class, [
            //     'label' => 'Association or Organization',
            //     'row_attr' => ['class' => 'col-6 mb-3'],
            //     'class' => Association::class,
            //     'attr' => ['class' => 'form-control']
            // ])
            // ->add('eventDates', CollectionType::class, [
            //     'row_attr' => ['class' => 'col-12 mb-3'],
            //     // 'class' => EventDates::class,
            //     'attr' => ['class' => 'form-control'],
            //     'allow_add' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
