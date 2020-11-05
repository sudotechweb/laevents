<?php

namespace App\Form;

use App\Entity\EventDates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventDateTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventDate', DateType::class, [
                'widget'=>'single_text',
                
            ])
            ->add('startingTime', TimeType::class, [
                'widget'=>'single_text',
                'required' => false,
                
            ])
            ->add('endingTime', TimeType::class, [
                'widget'=>'single_text',
                'required' => false,
                
            ])
            ->add('allday', CheckboxType::class, [
                'label' => 'All day event (8AM - 5PM)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventDates::class,
        ]);
    }
}
