<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $tailles = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $couleurs = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $tags = []; #Tag

    private ?string $sexe = null;

    private ?string $categorie = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Exemplaire::class, orphanRemoval: true)]
    private Collection $exemplaires;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column]
    private ?int $stock = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->exemplaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTailles(): array
    {
        return $this->tailles;
    }

    public function setTailles(array $tailles): static
    {
        $this->tailles = $tailles;

        return $this;
    }

    public function addTaille(string $taille): static
    {
        if (!in_array($taille, $this->tailles)){
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(array $taille): static
    {
        if (in_array($taille, $this->tailles)){
            unset($this->tailles[array_search($taille,$this->tailles)]);
        }

        return $this;
    }

    public function getCouleurs(): array
    {
        return $this->couleurs;
    }

    public function setCouleurs(array $couleurs): static
    {
        $this->couleurs = $couleurs;

        return $this;
    }

    public function addCouleur(string $couleur): static
    {
        if (in_array($couleur, $this->couleurs)){
            $this->couleurs[] = $couleur;
        } 

        return $this;
    }

    public function removeCouleur(array $couleur): static
    {
        if (in_array($couleur, $this->couleurs)){
            unset($this->couleurs[array_search($couleur,$this->couleurs)]);
        }

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): static
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setType($this);
            $this->addTaille($exemplaire->getTaille());
            $this->addCouleur($exemplaire->getCouleur());
            $this->addStock();
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): static
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getType() === $this) {
                $exemplaire->setType(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function addStock(int $stock = 1): static
    {
        $this->stock += $stock;

        return $this;
    }

    public function removeStock(int $stock = 1): static
    {
        $this->stock -= $stock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
