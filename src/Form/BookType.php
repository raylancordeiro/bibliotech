<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'title',
            ])
            ->add('publisher', TextType::class, [
                'label' => 'publisher',
            ])
            ->add('edition', TextType::class, [
                'label' => 'edition',
            ])
            ->add('publicationYear', IntegerType::class, [
                'label' => 'publication_year',
            ])
            ->add('price', TextType::class, [
                'label' => 'price',
                'attr' => [
                    'id' => 'price',
                    'inputmode' => 'decimal',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Price must be greater than 0.',
                    ]),
                    new NotBlank(),
                    new GreaterThanOrEqual(0.01),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
