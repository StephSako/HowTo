<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AnswerForum
 *
 * @ORM\Table(name="ANSWER_FORUM", indexes={@ORM\Index(name="id_FORUM_A_Fk", columns={"id_FORUM"}), @ORM\Index(name="id_USER_ANSWERER_F_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AnswerForumRepository")
 */
class AnswerForum
{

    public function __construct(?User $IdUser, Forum $id)
    {
        $this
            ->setDateresponse(new DateTime())
            ->setIdUser($IdUser)
            ->setIdForum($id);
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
     * @var \Forum
     *
     * @ORM\ManyToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_FORUM", referencedColumnName="id")
     * })
     */
    private $idForum;

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

    public function getIdForum(): ?Forum
    {
        return $this->idForum;
    }

    public function setIdForum(?Forum $idForum): self
    {
        $this->idForum = $idForum;

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
