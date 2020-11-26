<?php

namespace Backend\Modules\GoogleReview\Domain\GoogleReview;

use Backend\Form\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoogleReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'api_key',
            TextType::class,
            [
                'required' => false,
                'label' => 'lbl.ApiKey',
            ]
        )->add(
            'place_id',
            TextType::class,
            [
                'required' => false,
                'label' => 'lbl.PlaceId',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => GoogleReviewDataTransferObject::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'google_review';
    }
}
