<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SuggestionTutorial
 *
 * @ORM\Table(name="SUGGESTION_TUTORIAL", indexes={@ORM\Index(name="id_TUTORIAL_ST_Fk", columns={"id_TUTORIAL"}), @ORM\Index(name="id_USER_T_from_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SuggestionTutorialRepository")
 */
class SuggestionTutorial
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
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \Tutorial
     *
     * @ORM\ManyToOne(targetEntity="Tutorial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_TUTORIAL", referencedColumnName="id")
     * })
     */
    private $idTutorial;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_USER", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIdTutorial(): ?Tutorial
    {
        return $this->idTutorial;
    }

    public function setIdTutorial(?Tutorial $idTutorial): self
    {
        $this->idTutorial = $idTutorial;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
