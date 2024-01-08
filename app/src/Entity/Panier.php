<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nb_articles = null;

    #[ORM\Column]
    private ?float $prix_total = null;

    #[ORM\ManyToMany(targetEntity: Exemplaire::class)]
    private Collection $contenu;

    public function __construct()
    {
        $this->contenu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbArticles(): ?int
    {
        return $this->nb_articles;
    }

    public function setNbArticles(int $nb_articles): static
    {
        $this->nb_articles = $nb_articles;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): static
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getContenu(): Collection
    {
        return $this->contenu;
    }

    public function addContenu(Exemplaire $contenu): static
    {
        if (!$this->contenu->contains($contenu)) {
            $this->contenu->add($contenu);
        }

        return $this;
    }

    public function removeContenu(Exemplaire $contenu): static
    {
        $this->contenu->removeElement($contenu);

        return $this;
    }
}
