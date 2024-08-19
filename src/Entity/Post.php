<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["post:read", "post:write", "post:partial"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["post:read", "post:write", "post:partial"])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(["post:read", "post:write"])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["post:read", "post:write"])]
    private ?\DateTimeInterface $updated_at = null;


    // /**
    //  * @var Collection<int, Comment>
    //  */
    // #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'posts', orphanRemoval: true, cascade: ['persist', 'remove'])]
    // #[Groups(["post:read"])]
    // private Collection $comments;

    // #[ORM\ManyToOne(inversedBy: 'posts')]
    // #[Groups(["post:read"])]
    // private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(["post:read", "post:write", "post:partial"])]
    private ?string $content = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    #[Groups(["post:partial"])]
    private Collection $categories;

    public function __construct()
    {

        // $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    /**
     * @return Collection<int, comment>
     */
    // public function getComments(): Collection
    // {
    //     return $this->comments;
    // }

    // public function addComment(comment $comment): static
    // {
    //     if (!$this->comments->contains($comment)) {
    //         $this->comments->add($comment);
    //         $comment->setPosts($this);
    //     }

    //     return $this;
    // }

    // public function removeComment(comment $comment): static
    // {
    //     if ($this->comments->removeElement($comment)) {
    //         // set the owning side to null (unless already changed)
    //         if ($comment->getPosts() === $this) {
    //             $comment->setPosts(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function getUser(): ?User
    // {
    //     return $this->user;
    // }

    // public function setUser(?User $userid): static
    // {
    //     $this->user = $userid;

    //     return $this;
    // }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
