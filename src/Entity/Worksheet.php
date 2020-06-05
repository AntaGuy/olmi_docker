<?php

namespace App\Entity;

use App\Repository\WorksheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=WorksheetRepository::class)
 */
class Worksheet
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
     * @ORM\ManyToOne(targetEntity=Family::class, inversedBy="worksheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, inversedBy="worksheet", cascade={"persist", "remove"})
     */
    private $page;

    /**
     * @ORM\ManyToMany(targetEntity=Aid::class, inversedBy="worksheets")
     */
    private $aids;

    /**
     * @ORM\OneToOne(targetEntity=Panel::class, cascade={"persist", "remove"})
     */
    private $panel;

    /**
     * @ORM\ManyToMany(targetEntity=Worksheet::class)
     * @ORM\JoinTable(name="worksheet_compatible",
     *      joinColumns={@ORM\JoinColumn(name="worksheet_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="compatible_worksheet_id", referencedColumnName="id")}
     *      )
     */
    private $compatibleWorksheets;

    public function __construct()
    {
        $this->aids = new ArrayCollection();
        $this->compatibleWorksheets = new ArrayCollection();
    }

    public function __toString()
    {
        return str_replace('//', '', $this->title);
    }

    public function getSlug()
    {
        if ($this->getPage() instanceof Page) {
            return $this->getPage()->getSlug();
        }

        return false;
    }

    /** AUTO GENERATED */

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

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Collection|Aid[]
     */
    public function getAids(): Collection
    {
        return $this->aids;
    }

    public function addAid(Aid $aid): self
    {
        if (!$this->aids->contains($aid)) {
            $this->aids[] = $aid;
        }

        return $this;
    }

    public function removeAid(Aid $aid): self
    {
        if ($this->aids->contains($aid)) {
            $this->aids->removeElement($aid);
        }

        return $this;
    }

    public function getPanel(): ?Panel
    {
        return $this->panel;
    }

    public function setPanel(?Panel $panel): self
    {
        $this->panel = $panel;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCompatibleWorksheets(): Collection
    {
        return $this->compatibleWorksheets;
    }

    public function addCompatibleWorksheet(self $compatibleWorksheet): self
    {
        if (!$this->compatibleWorksheets->contains($compatibleWorksheet)) {
            $this->compatibleWorksheets[] = $compatibleWorksheet;
        }

        return $this;
    }

    public function removeCompatibleWorksheet(self $compatibleWorksheet): self
    {
        if ($this->compatibleWorksheets->contains($compatibleWorksheet)) {
            $this->compatibleWorksheets->removeElement($compatibleWorksheet);
        }

        return $this;
    }
}
