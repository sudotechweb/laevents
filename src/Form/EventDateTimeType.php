<?php

namespace App\Form;

use App\Entity\EventDates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventDateTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget'=>'single_text',
                
            ])
            ->add('endDate', DateTimeType::class, [
                'widget'=>'single_text',
                
            ])
            ->add('allday')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventDates::class,
        ]);
    }
}
