<?php

namespace RssCleanerBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestExpressionssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'expression',
            EntityType::class,
            array(
                'class' => 'RssCleanerBundle\Entity\Expression',
                'choice_label' => 'expression',
                'expanded' => true,
                'multiple' => false
            )
        )
        ->add(
            'limit',
            RangeType::class,
            array(
                'attr' => array(
                    'min' => 1,
                    'max' => 50
                )
            )
        )
        ->add(
            'test',
            SubmitType::class
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'rss_cleaner_bundle_test_expressionss_type';
    }
}
