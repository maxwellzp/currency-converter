<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', NumberType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\Positive(),
                ]
            ])
            ->add('fromCurrency', ChoiceType::class, [
                'choices' => [
                    'BTC' => 'BTC',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'UAH' => 'UAH',
                ],
                'mapped' => false,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])
            ->add('toCurrency', ChoiceType::class, [
                'choices' => [
                    'BTC' => 'BTC',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'UAH' => 'UAH',
                ],
                'mapped' => false,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ]);
    }
}