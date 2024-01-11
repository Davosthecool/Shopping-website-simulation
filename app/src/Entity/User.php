<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Article::class)]
    private Collection $favoris;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private Panier $panier;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Panier $panier;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class)]
    private Collection $historique;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PayCard::class, orphanRemoval: true)]
    private Collection $paycards;

    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column(length: 64)]
    private ?string $nom = null;

    #[ORM\Column(length: 64)]
    private ?string $prenom = null;

    public function __construct()
    {
        $this->setPanier(new Panier);
        $this->favoris = new ArrayCollection();
        $this->historique = new ArrayCollection();
        $this->paycards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Article $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Article $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(Panier $panier): static
    {
        // set the owning side of the relation if necessary
        if ($panier->getUtilisateur() !== $this) {
            $panier->setUtilisateur($this);
        }

        $this->panier = $panier;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getHistorique(): Collection
    {
        return $this->historique;
    }

    public function addHistorique(Commande $historique): static
    {
        if (!$this->historique->contains($historique)) {
            $this->historique->add($historique);
            $historique->setUser($this);
        }

        return $this;
    }

    public function removeHistorique(Commande $historique): static
    {
        if ($this->historique->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getUser() === $this) {
                $historique->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PayCard>
     */
    public function getPaycards(): Collection
    {
        return $this->paycards;
    }

    public function addPaycard(PayCard $paycard): static
    {
        if (!$this->paycards->contains($paycard)) {
            $this->paycards->add($paycard);
            $paycard->setUser($this);
        }

        return $this;
    }

    public function removePaycard(PayCard $paycard): static
    {
        if ($this->paycards->removeElement($paycard)) {
            // set the owning side to null (unless already changed)
            if ($paycard->getUser() === $this) {
                $paycard->setUser(null);
            }
        }

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
}
