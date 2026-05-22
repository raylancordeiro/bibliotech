<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['description'],
    message: 'subject_already_exists'
)]
#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Subject
{
    #[ORM\Column]
    #[ORM\GeneratedValue]
    #[ORM\Id]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Subject description must contain at least {{ limit }} characters.',
        maxMessage: 'Subject description cannot exceed {{ limit }} characters.'
    )]
    #[Assert\NotBlank(message: 'Subject description is required.')]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, BookSubject>
     */
    #[ORM\OneToMany(targetEntity: BookSubject::class, mappedBy: 'subject')]
    private Collection $bookSubjects;

    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, BookSubject>
     */
    public function getBookSubjects(): Collection
    {
        return $this->bookSubjects;
    }
}
