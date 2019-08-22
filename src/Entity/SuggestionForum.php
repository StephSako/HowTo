<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SuggestionForum
 *
 * @ORM\Table(name="SUGGESTION_FORUM", indexes={@ORM\Index(name="id_FORUM_SF_Fk", columns={"id_FORUM"}), @ORM\Index(name="id_USER_F_from_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SuggestionForumRepository")
 */
class SuggestionForum
{

    public function __construct(?User $user, Forum $forum)
    {
        $this
            ->setIdUser($user)
            ->setIdForum($forum);
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
