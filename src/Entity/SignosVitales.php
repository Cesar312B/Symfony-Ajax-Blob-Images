<?php

namespace App\Entity;

use App\Repository\SignosVitalesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignosVitalesRepository::class)
 */
class SignosVitales
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $presion_arterial;

    /**
     * @ORM\Column(type="integer")
     */
    private $frecuencia_cardiaca;

    /**
     * @ORM\Column(type="float")
     */
    private $temperatura;

    /**
     * @ORM\Column(type="integer")
     */
    private $frecuencia_respiratoria;

    /**
     * @ORM\OneToOne(targetEntity=Consulta::class, inversedBy="signosVitales", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $consulta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresionArterial(): ?int
    {
        return $this->presion_arterial;
    }

    public function setPresionArterial(int $presion_arterial): self
    {
        $this->presion_arterial = $presion_arterial;

        return $this;
    }

    public function getFrecuenciaCardiaca(): ?int
    {
        return $this->frecuencia_cardiaca;
    }

    public function setFrecuenciaCardiaca(int $frecuencia_cardiaca): self
    {
        $this->frecuencia_cardiaca = $frecuencia_cardiaca;

        return $this;
    }

    public function getTemperatura(): ?int
    {
        return $this->temperatura;
    }

    public function setTemperatura(int $temperatura): self
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    public function getFrecuenciaRespiratoria(): ?int
    {
        return $this->frecuencia_respiratoria;
    }

    public function setFrecuenciaRespiratoria(int $frecuencia_respiratoria): self
    {
        $this->frecuencia_respiratoria = $frecuencia_respiratoria;

        return $this;
    }

    public function getConsulta(): ?Consulta
    {
        return $this->consulta;
    }

    public function setConsulta(Consulta $consulta): self
    {
        $this->consulta = $consulta;

        return $this;
    }
}
