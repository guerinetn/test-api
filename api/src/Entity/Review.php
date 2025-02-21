<?php
// api/src/Entity/Review.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\Clock\now;

/** A review of a book. */
#[ORM\Entity]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(validationContext: ['groups' => ['Default','review:create']]),
        new Get(),
    ],
    normalizationContext: ['groups' => ['review:read','book:read']],
    denormalizationContext: ['groups'=>['review:create']],
)]
class Review
{
    /** The ID of this review. */
    #[ORM\Id, ORM\Column, ORM\GeneratedValue('SEQUENCE')]
    #[Groups(['review:read'])]
    private ?int $id = null;

    /** The rating of this review (between 0 and 5). */
    #[Groups(['review:read','review:create'])]
    #[ORM\Column(type: 'smallint')]
    #[Assert\Range(min: 0, max: 5)]
    public int $rating = 0;

    /** The body of the review. */
    #[Groups(['review:read','review:create'])]
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    public string $body = '';

    /** The author of the review. */
    #[Groups(['review:read','review:create'])]
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $author = '';

    /** The date of publication of this review.*/
    #[Groups(['review:read'])]
    #[ORM\Column]
    public ?\DateTimeImmutable $publicationDate=null;

    /** The book this review is about. */
    #[Groups(['review:read','review:create'])]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[Assert\NotNull]
    public ?Book $book = null;

    public function __construct()
    {
        $this->publicationDate = now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
