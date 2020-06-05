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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ctaLabel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metaTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $metaDescription;

    /**
     * @Gedmo\SortablePosition
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
    private $pageBlocks;

    /**
     * @ORM\OneToOne(targetEntity=Family::class, mappedBy="page", cascade={"persist", "remove"})
     */
    private $family;

    /**
     * @ORM\OneToOne(targetEntity=Worksheet::class, mappedBy="page", cascade={"persist", "remove"})
     */
    private $worksheet;

    /**
     * @ORM\OneToOne(targetEntity=Aid::class, mappedBy="page", cascade={"persist", "remove"})
     */
    private $aid;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->position = $this->getId();
        $this->pageBlocks = new ArrayCollection();
    }

    public function __toString()
    {
        return str_replace('//', '', $this->title);
    }

    public function isCms(): bool
    {
        return !$this->aid && !$this->worksheet && !$this->family;
    }

    /** AUTO GENERATED **/

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
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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
        return $this->pageBlocks;
    }

    public function addPageBlock(PageBlock $pageBlock): self
    {
        if (!$this->pageBlocks->contains($pageBlock)) {
            $this->pageBlocks[] = $pageBlock;
            $pageBlock->setPage($this);
        }

        return $this;
    }

    public function removePageBlock(PageBlock $pageBlock): self
    {
        if ($this->pageBlocks->contains($pageBlock)) {
            $this->pageBlocks->removeElement($pageBlock);
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

    public function getAid(): ?Aid
    {
        return $this->aid;
    }

    public function setAid(?Aid $aid): self
    {
        $this->aid = $aid;

        // set (or unset) the owning side of the relation if necessary
        $new_page = null === $aid ? null : $this;
        if ($aid->getPage() !== $new_page) {
            $aid->setPage($new_page);
        }

        return $this;
    }

    public function getCta(): ?string
    {
        return $this->cta;
    }

    public function setCta(?string $cta): self
    {
        $this->cta = $cta;

        return $this;
    }

    public function getCtaLabel(): ?string
    {
        return $this->ctaLabel;
    }

    public function setCtaLabel(?string $ctaLabel): self
    {
        $this->ctaLabel = $ctaLabel;

        return $this;
    }
}
