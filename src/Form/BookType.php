<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Subject;
use App\Repository\AuthorRepository;
use App\Repository\SubjectRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'authors',
                'mapped' => false,
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'query_builder' => fn (AuthorRepository $repository) => $repository
                    ->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC'),
                'attr' => [
                    'class' => 'form-select form-select-lg js-tom-select',
                ],
            ])

            ->add('subjects', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'description',
                'label' => 'subjects',
                'mapped' => false,
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'query_builder' => fn (SubjectRepository $repository) => $repository
                    ->createQueryBuilder('s')
                    ->orderBy('s.description', 'ASC'),
                'attr' => [
                    'class' => 'form-select form-select-lg js-tom-select',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
