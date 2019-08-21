<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumReporting
 *
 * @ORM\Table(name="FORUM_REPORTING", indexes={@ORM\Index(name="id_FORUM_REPORT_Fk", columns={"id_FORUM"}), @ORM\Index(name="id_REPORTING_LABEL_FOR_Fk", columns={"id_REPORTING_LABEL"}), @ORM\Index(name="id_USER_REPORT_FOR_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ForumReportingRepository")
 */
class ForumReporting
{

    public function __construct($user, $forum){
        $this->setIdUser($user)
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
     * @var \Forum
     *
     * @ORM\ManyToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_FORUM", referencedColumnName="id")
     * })
     */
    private $idForum;

    /**
     * @var \ReportingLabel
     *
     * @ORM\ManyToOne(targetEntity="ReportingLabel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_REPORTING_LABEL", referencedColumnName="id")
     * })
     */
    private $idReportingLabel;

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

    public function getIdForum(): ?Forum
    {
        return $this->idForum;
    }

    public function setIdForum(?Forum $idForum): self
    {
        $this->idForum = $idForum;

        return $this;
    }

    public function getIdReportingLabel(): ?ReportingLabel
    {
        return $this->idReportingLabel;
    }

    public function setIdReportingLabel(?ReportingLabel $idReportingLabel): self
    {
        $this->idReportingLabel = $idReportingLabel;

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
