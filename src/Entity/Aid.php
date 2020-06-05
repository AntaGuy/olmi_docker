<?php

namespace App\Entity;

use App\Repository\AidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AidRepository::class)
 */
class Aid
{
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
     * @ORM\OneToOne(targetEntity=Panel::class, cascade={"persist", "remove"})
     */
    private $panel;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, inversedBy="aid", cascade={"persist", "remove"})
     */
    private $page;

    /**
     * @ORM\ManyToMany(targetEntity=Worksheet::class, mappedBy="aids")
     */
    private $worksheets;

    /**
     * @ORM\ManyToMany(targetEntity=Aid::class)
     * @ORM\JoinTable(name="aid_compatible",
     *      joinColumns={@ORM\JoinColumn(name="aid_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="compatible_aid_id", referencedColumnName="id")}
     *      )
     */
    private $compatibleAids;

    public function __construct()
    {
        $this->worksheets = new ArrayCollection();
        $this->compatibleAids = new ArrayCollection();
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

    public function getPanel(): ?Panel
    {
        return $this->panel;
    }

    public function setPanel(?Panel $panel): self
    {
        $this->panel = $panel;

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
     * @return Collection|Worksheet[]
     */
    public function getWorksheets(): Collection
    {
        return $this->worksheets;
    }

    public function addWorksheet(Worksheet $worksheet): self
    {
        if (!$this->worksheets->contains($worksheet)) {
            $this->worksheets[] = $worksheet;
            $worksheet->addAid($this);
        }

        return $this;
    }

    public function removeWorksheet(Worksheet $worksheet): self
    {
        if ($this->worksheets->contains($worksheet)) {
            $this->worksheets->removeElement($worksheet);
            $worksheet->removeAid($this);
        }

        return $this;
    }

    /**
     * @return Collection|Aid[]
     */
    public function getCompatibleAids(): Collection
    {
        return $this->compatibleAids;
    }

    public function addCompatibleAid(Aid $compatibleAid): self
    {
        if (!$this->compatibleAids->contains($compatibleAid)) {
            $this->compatibleAids[] = $compatibleAid;
        }

        return $this;
    }

    public function removeCompatibleAid(Aid $compatibleAid): self
    {
        if ($this->compatibleAids->contains($compatibleAid)) {
            $this->compatibleAids->removeElement($compatibleAid);
        }

        return $this;
    }
}
