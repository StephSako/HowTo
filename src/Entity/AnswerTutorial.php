<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AnswerTutorial
 *
 * @ORM\Table(name="ANSWER_TUTORIAL", indexes={@ORM\Index(name="id_TUTORIAL_A_Fk", columns={"id_TUTORIAL"}), @ORM\Index(name="id_USER_ANSWERER_T_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AnswerTutorialRepository")
 */
class AnswerTutorial
{

    /**
     * AnswerTutorial constructor.
     * @param User|null $IdUser
     * @param Tutorial $id
     * @throws \Exception
     */
    public function __construct(?User $IdUser, Tutorial $id)
    {
        $this
            ->setDateresponse(new DateTime())
            ->setIdUser($IdUser)
            ->setIdTutorial($id);
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateResponse", type="datetime", nullable=false)
     */
    private $dateresponse;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 3,
     *      max = 500,
     *      minMessage = "Votre commentaire doit contenir au moins {{ limit }} letttres",
     *      maxMessage = "Votre commentaire doit contenir au maximum {{ limit }} letttres"
     *     )
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

    public function getDateresponse(): ?\DateTimeInterface
    {
        return $this->dateresponse;
    }

    public function setDateresponse(\DateTimeInterface $dateresponse): self
    {
        $this->dateresponse = $dateresponse;

        return $this;
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
