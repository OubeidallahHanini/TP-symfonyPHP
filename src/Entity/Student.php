<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Classroom::class, orphanRemoval: true)]
    private Collection $classe;

    #[ORM\Column]
    private ?float $mo = null;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classroom $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe->add($classe);
            $classe->setStudent($this);
        }

        return $this;
    }

    public function removeClasse(Classroom $classe): self
    {
        if ($this->classe->removeElement($classe)) {
            // set the owning side to null (unless already changed)
            if ($classe->getStudent() === $this) {
                $classe->setStudent(null);
            }
        }

        return $this;
    }

    public function getMo(): ?float
    {
        return $this->mo;
    }

    public function setMo(float $mo): self
    {
        $this->mo = $mo;

        return $this;
    }
}
