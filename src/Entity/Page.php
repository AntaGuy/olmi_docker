<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
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
    private $intro_title;

    /**
     * @ORM\Column(type="text")
     */
    private $intro_description;

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
     * Constructor 
     */
    public function __construct()
    {
        $this->page_blocks = new ArrayCollection();
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

    public function getIntroTitle(): ?string
    {
        return $this->intro_title;
    }

    public function setIntroTitle(string $intro_title): self
    {
        $this->intro_title = $intro_title;

        return $this;
    }

    public function getIntroDesciption(): ?string
    {
        return $this->intro_desciption;
    }

    public function setIntroDesciption(string $intro_desciption): self
    {
        $this->intro_desciption = $intro_desciption;

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

    public function getIntroDescription(): ?string
    {
        return $this->intro_description;
    }

    public function setIntroDescription(string $intro_description): self
    {
        $this->intro_description = $intro_description;

        return $this;
    }
    
}
