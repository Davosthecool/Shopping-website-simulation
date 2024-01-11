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
    protected ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'panier', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column]
    protected ?int $nb_articles = 0;

    #[ORM\Column]
    protected ?float $prix_total = 0;

    #[ORM\ManyToMany(targetEntity: Exemplaire::class)]
    protected Collection $contenu;

    public function __construct()
    {
        $this->contenu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
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
        }else{
            $this->contenu->get($this->contenu->indexOf($contenu))->addQuantite();
        }
        $this->setNbArticles($this->getNbArticles()+1);
        $this->setPrixTotal($this->getPrixTotal()+$contenu->getType()->getPrix());

        return $this;
    }

    public function removeContenu(Exemplaire $contenu): static
    {
        $this->contenu->removeElement($contenu);

        return $this;
    }

}
