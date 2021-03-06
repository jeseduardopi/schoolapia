<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $nomClasse;

    /**
     * @ORM\ManyToOne(targetEntity=Etablissement::class, inversedBy="classes")
     */
    private $etablissement;

    /**
     * @ORM\OneToOne(targetEntity=EmploiDuTemps::class, inversedBy="classes", cascade={"persist", "remove"})
     */
    private $EmploiDuTemps;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="classes", cascade={"persist"})
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }

    public function __toString()
    {
        if (is_null($this->nomClasse)) {
            return "";
        }
        return $this->nomClasse;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nomClasse;
    }

    public function setNomClasse(string $nomClasse): self
    {
        $this->nomClasse = $nomClasse;

        return $this;
    }

    public function getEtablissement(): ?etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getEmploiDuTemps(): ?EmploiDuTemps
    {
        return $this->EmploiDuTemps;
    }

    public function setEmploiDuTemps(?EmploiDuTemps $EmploiDuTemps): self
    {
        $this->EmploiDuTemps = $EmploiDuTemps;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(User $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setClasses($this);
        }

        return $this;
    }

    public function removeUtilisateur(User $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getClasses() === $this) {
                $utilisateur->setClasses(null);
            }
        }

        return $this;
    }
}
