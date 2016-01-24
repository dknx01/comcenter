<?php

namespace RssCleanerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpressionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'expression',
                TextType::class,
                array(
                    'label' => 'Expression',
                    'required' => true,
                    'empty_data' => 'Your expression'
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Speichern'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }


    public function getName()
    {
        return 'rss_cleaner_bundle_expression_type';
    }
}
