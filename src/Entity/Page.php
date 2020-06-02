<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @UniqueEntity("slug")
 */
class Page
{
    use TimestampableEntity, SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $meta_title;

    /**
     * @ORM\Column(type="text")
     */
    private $meta_description;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * Indicate if the page is enabled (available to publish).
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * List of pages_blocks
     *
     * @ORM\OneToMany(targetEntity="App\Entity\PageBlock", cascade={"persist"}, mappedBy="page")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $page_blocks;

    /**
     * @ORM\OneToOne(targetEntity=Family::class, mappedBy="page", cascade={"persist", "remove"})
     */
    private $family;

    /**
     * @ORM\OneToOne(targetEntity=Worksheet::class, mappedBy="page", cascade={"persist", "remove"})
     */
    private $worksheet;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->page_blocks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|PageBlock[]
     */
    public function getPageBlocks(): Collection
    {
        return $this->page_blocks;
    }

    public function addPageBlock(PageBlock $pageBlock): self
    {
        if (!$this->page_blocks->contains($pageBlock)) {
            $this->page_blocks[] = $pageBlock;
            $pageBlock->setPage($this);
        }

        return $this;
    }

    public function removePageBlock(PageBlock $pageBlock): self
    {
        if ($this->page_blocks->contains($pageBlock)) {
            $this->page_blocks->removeElement($pageBlock);
            // set the owning side to null (unless already changed)
            if ($pageBlock->getPage() === $this) {
                $pageBlock->setPage(null);
            }
        }

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        // set (or unset) the owning side of the relation if necessary
        $new_page = null === $family ? null : $this;
        if ($family->getPage() !== $new_page) {
            $family->setPage($new_page);
        }

        return $this;
    }

    public function getWorksheet(): ?Worksheet
    {
        return $this->worksheet;
    }

    public function setWorksheet(?Worksheet $worksheet): self
    {
        $this->worksheet = $worksheet;

        // set (or unset) the owning side of the relation if necessary
        $new_page = null === $worksheet ? null : $this;
        if ($worksheet->getPage() !== $new_page) {
            $worksheet->setPage($new_page);
        }

        return $this;
    }
    
}
