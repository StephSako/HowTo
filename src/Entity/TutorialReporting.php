<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TutorialReporting
 *
 * @ORM\Table(name="TUTORIAL_REPORTING", indexes={@ORM\Index(name="id_TUTORIAL_REPORT_Fk", columns={"id_TUTORIAL"}), @ORM\Index(name="id_REPORTING_LABEL_TUTO_Fk", columns={"id_REPORTING_LABEL"}), @ORM\Index(name="id_USER_REPORT_TUTO_Fk", columns={"id_USER"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TutorialReportingRepository")
 */
class TutorialReporting
{

    public function __construct($user, $tutorial){
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
     * @var \ReportingLabel
     *
     * @ORM\ManyToOne(targetEntity="ReportingLabel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_REPORTING_LABEL", referencedColumnName="id")
     * })
     */
    private $idReportingLabel;

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

    public function getIdReportingLabel(): ?ReportingLabel
    {
        return $this->idReportingLabel;
    }

    public function setIdReportingLabel(?ReportingLabel $idReportingLabel): self
    {
        $this->idReportingLabel = $idReportingLabel;

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
