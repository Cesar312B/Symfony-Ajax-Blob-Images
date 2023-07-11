<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultaRepository::class)
 */
class Consulta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $motivo_consulta;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="consultas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Paciente::class, inversedBy="consultas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paciente;

    /**
     * @ORM\OneToOne(targetEntity=SignosVitales::class, mappedBy="consulta", cascade={"persist", "remove"})
     */
    private $signosVitales;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotivoConsulta(): ?string
    {
        return $this->motivo_consulta;
    }

    public function setMotivoConsulta(string $motivo_consulta): self
    {
        $this->motivo_consulta = $motivo_consulta;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): self
    {
        $this->paciente = $paciente;

        return $this;
    }

    public function getSignosVitales(): ?SignosVitales
    {
        return $this->signosVitales;
    }

    public function setSignosVitales(SignosVitales $signosVitales): self
    {
        // set the owning side of the relation if necessary
        if ($signosVitales->getConsulta() !== $this) {
            $signosVitales->setConsulta($this);
        }

        $this->signosVitales = $signosVitales;

        return $this;
    }
}
