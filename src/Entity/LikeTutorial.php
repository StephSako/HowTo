<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeTutorial
 *
 * @ORM\Table(name="LIKE_TUTORIAL", indexes={@ORM\Index(name="id_TUTORIAL_LIKE_Fk", columns={"id_TUTORIAL"}), @ORM\Index(name="id_USER_T_LIKE_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\LikeTutorialRepository")
 */
class LikeTutorial
{

    public function __construct(User $user, Tutorial $tutorial)
    {
        $this->setIdUser($user)
            ->setIdTutorial($tutorial);
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
