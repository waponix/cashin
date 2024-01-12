<?php

namespace App\Form;

use App\Entity\Transaction;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referenceId', TextType::class, [
                'label' => 'Reference Number',
                'required' => true,
                'attr' => [
                    'placeholder' => '- - - - - - - - - - - -',
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=> 'should be filled',
                    ])
                ],
                'invalid_message' => 'is not valid',
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Mobile Number',
                'required' => true,
                'attr' => [
                    'placeholder' => '00000000000',
                    'maxlength' => 11,
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=> 'should be filled',
                    ])
                ],
                'invalid_message' => 'is not valid',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Transaction',
                'required' => true,
                'choices' => Transaction::TYPES,
                'invalid_message' => 'is not valid',
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'required' => true,
                'attr' => [
                    'placeholder' => '00.00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=> 'should be filled',
                    ])
                ],
                'invalid_message' => 'is not valid',
            ])
            ->add('transactionedAt', TextType::class, [
                'label' => 'Date',
                'required' => true,
                'attr' => [
                    'placeholder' => 'MM/DD/YYYY',
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=> 'should be filled',
                    ])
                ],
                'invalid_message' => 'is not valid',
            ]);

        $builder
            ->get('transactionedAt')
            ->addModelTransformer(new CallbackTransformer(
                function ($date) {
                    return $date;
                },
                function ($date) {
                    if (strtotime($date) === false) {
                        return null;
                    }
                    return new \DateTimeImmutable($date);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
