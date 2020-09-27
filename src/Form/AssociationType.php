<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logoImage', FileType::class, [
                'label' => 'Logo',
                'row_attr' => ['class' => 'col-12 mb-3'],
                'attr' => ['class' => 'form-control'],

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('name', TextType::class, [
                'row_attr' => ['class' => 'col-12 mb-3'],
                'attr' => ['class' => 'form-control', 'tabIndex' => 1]
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'row_attr' => ['class' => 'col-12 mb-3'],
                'attr' => ['class' => 'form-control', 'tabIndex' => 2]
            ])
            ->add('phone', TextType::class, [
                'required' => false,
                'row_attr' => ['class' => 'col-12 mb-3'],
                'attr' => ['class' => 'form-control', 'tabIndex' => 3]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'row_attr' => ['class' => 'col-12 mb-3'],
                'attr' => ['class' => 'form-control', 'tabIndex' => 4]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
