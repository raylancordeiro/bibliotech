<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Book
{
    #[ORM\Column]
    #[ORM\GeneratedValue]
    #[ORM\Id]
    private ?int $id = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'Title cannot exceed {{ limit }} characters.'
    )]
    #[Assert\NotBlank(message: 'Title is required.')]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'Publisher cannot exceed {{ limit }} characters.'
    )]
    #[Assert\NotBlank(message: 'Publisher is required.')]
    #[ORM\Column(length: 255)]
    private ?string $publisher = null;

    #[Assert\Length(
        max: 50,
        maxMessage: 'Edition cannot exceed {{ limit }} characters.'
    )]
    #[Assert\NotBlank(message: 'Edition is required.')]
    #[ORM\Column(length: 50)]
    private ?string $edition = null;

    #[Assert\NotNull(message: 'Publication year is required.')]
    #[Assert\Range(
        notInRangeMessage: 'Publication year must be between {{ min }} and {{ max }}.',
        min: 1500,
        max: 2100
    )]
    #[ORM\Column]
    private ?int $publicationYear = null;

    #[Assert\NotBlank(message: 'Price is required.')]
    #[Assert\Positive(message: 'Price must be greater than zero.')]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    /**
     * @var Collection<int, BookAuthor>
     */
    #[ORM\OneToMany(
        targetEntity: BookAuthor::class,
        mappedBy: 'book',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $bookAuthors;

    /**
     * @var Collection<int, BookSubject>
     */
    #[ORM\OneToMany(
        targetEntity: BookSubject::class,
        mappedBy: 'book',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $bookSubjects;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->bookAuthors = new ArrayCollection();
        $this->bookSubjects = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(string $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(int $publicationYear): static
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, BookAuthor>
     */
    public function getBookAuthors(): Collection
    {
        return $this->bookAuthors;
    }

    public function addBookAuthor(BookAuthor $bookAuthor): static
    {
        if (!$this->bookAuthors->contains($bookAuthor)) {

            $this->bookAuthors->add($bookAuthor);

            $bookAuthor->setBook($this);
        }

        return $this;
    }

    public function removeBookAuthor(BookAuthor $bookAuthor): static
    {
        if ($this->bookAuthors->removeElement($bookAuthor)) {

            if ($bookAuthor->getBook() === $this) {
                $bookAuthor->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookSubject>
     */
    public function getBookSubjects(): Collection
    {
        return $this->bookSubjects;
    }

    public function addBookSubject(BookSubject $bookSubject): static
    {
        if (!$this->bookSubjects->contains($bookSubject)) {

            $this->bookSubjects->add($bookSubject);

            $bookSubject->setBook($this);
        }

        return $this;
    }

    public function removeBookSubject(BookSubject $bookSubject): static
    {
        if ($this->bookSubjects->removeElement($bookSubject)) {

            if ($bookSubject->getBook() === $this) {
                $bookSubject->setBook(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
