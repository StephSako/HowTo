<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportingLabel
 *
 * @ORM\Table(name="REPORTING_LABEL")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ReportingLabelRepository")
 */
class ReportingLabel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="text", length=255, nullable=false)
     */
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }


}
