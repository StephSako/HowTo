<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Informations
 *
 * @ORM\Table(name="INFORMATIONS", indexes={@ORM\Index(name="id_USER_Infos", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\InformationsRepository")
 */
class Informations
{

    /**
     * Informations constructor.
     * @param User $user
     * @throws \Exception
     */
    public function __construct(?User $user)
    {
        $this
            ->setDatedemande(new DateTime())
            ->setIdUser($user);
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
     * @var string
     **
     * @Assert\Length(
     *      min = 10,
     *      max = 240,
     *      minMessage = "Votre message doit contenir au moins {{ limit }} letttres",
     *      maxMessage = "Votre message doit contenir au maximum {{ limit }} letttres"
     *     )
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDemande", type="datetime", nullable=false)
     */
    private $datedemande;

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

    /**
     * @return \DateTimeInterface|null
     */
    public function getDatedemande(): ?\DateTimeInterface
    {
        return $this->datedemande;
    }

    /**
     * @param \DateTimeInterface $datedemande
     * @return Informations
     */
    public function setDatedemande(\DateTimeInterface $datedemande): self
    {
        $this->datedemande = $datedemande;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    /**
     * @param User|null $idUser
     * @return Informations
     */
    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Informations
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


}
