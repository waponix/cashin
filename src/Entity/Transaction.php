<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    const TYPES = [
        'Cash In' => 'cash in',
        'Cash Out' => 'cash out',
        'Buy Load' => 'buy load',
        'Pay Bill' => 'pay bill',
    ];
    
    // $id
    // ORM configurations
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    // $referenceId
    // ORM configurations
    #[ORM\Column(length: 16, unique: true)]
    // Assertions
    #[Assert\NotNull(message: 'cannot be blank')]
    private ?string $referenceId = null;

    // $user
    // ORM configurations
    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // $type
    // ORM configurations
    #[ORM\Column(length: 15)]
    // Assertions
    #[Assert\NotNull(message: 'cannot be blank')]
    private ?string $type = null;

    // $amount
    // ORM configurations
    #[ORM\Column]
    // Assertions
    #[Assert\NotNull(message: 'cannot be blank')]
    private ?float $amount = null;

    // $details
    // ORM configurations
    #[ORM\Column(nullable: true)]
    private ?array $details = null;

    // $createdAt
    // ORM configurations
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // $updatedAt
    // ORM configurations
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    // $screenshot
    // ORM configurations
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $screenshot = null;

    // $message
    // ORM configurations
    #[ORM\Column(nullable: true)]
    // Assertions
    #[Assert\NotNull(message: 'cannot be blank')]
    private ?\DateTimeImmutable $transactionedAt = null;

    // $mobile
    // ORM configurations
    #[ORM\Column(length: 15, nullable: true)]
    // Assertions
    #[Assert\NotNull(message: 'cannot be blank')]
    private ?string $mobile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): static
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(?array $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getScreenshot(): ?string
    {
        return $this->screenshot;
    }

    public function setScreenshot(?string $screenshot): static
    {
        $this->screenshot = $screenshot;

        return $this;
    }

    #[ORM\PrePersist]
    public function initTimestamp(): void
    {
        if ($this->createdAt === null) {
            $this->updatedAt = clone $this->createdAt = new \DateTimeImmutable();
        }
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getTransactionedAt(): ?\DateTimeImmutable
    {
        return $this->transactionedAt;
    }

    public function setTransactionedAt(?\DateTimeImmutable $transactionedAt): static
    {
        $this->transactionedAt = $transactionedAt;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }
}
