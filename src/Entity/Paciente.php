<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PacienteRepository::class)
 */
class Paciente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Sexo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_nacimiento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cedula;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image_profile;

    private $rawPhoto;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_ingreso;

    /**
     * @ORM\OneToMany(targetEntity=Consulta::class, mappedBy="paciente", orphanRemoval=true)
     */
    private $consultas;

    public function __construct()
    {
        $this->consultas = new ArrayCollection();
    }

public function displayPhoto()
{
    if(null === $this->rawPhoto && $this->getImageProfile() != null) {
        $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getImageProfile()));
    }

    return $this->rawPhoto;
}


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->Apellido;
    }

    public function setApellido(string $Apellido): self
    {
        $this->Apellido = $Apellido;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->Sexo;
    }

    public function setSexo(string $Sexo): self
    {
        $this->Sexo = $Sexo;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getCedula(): ?string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): self
    {
        $this->cedula = $cedula;

        return $this;
    }

    public function getImageProfile()
    {
        return $this->image_profile;
    }

    public function setImageProfile($image_profile): self
    {
        $this->image_profile = $image_profile;

        return $this;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fecha_ingreso;
    }

    public function setFechaIngreso(?\DateTimeInterface $fecha_ingreso): self
    {
        $this->fecha_ingreso = $fecha_ingreso;

        return $this;
    }

    /**
     * @return Collection<int, Consulta>
     */
    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function addConsulta(Consulta $consulta): self
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas[] = $consulta;
            $consulta->setPaciente($this);
        }

        return $this;
    }

    public function removeConsulta(Consulta $consulta): self
    {
        if ($this->consultas->removeElement($consulta)) {
            // set the owning side to null (unless already changed)
            if ($consulta->getPaciente() === $this) {
                $consulta->setPaciente(null);
            }
        }

        return $this;
    }
}
