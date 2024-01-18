<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type")]
#[ORM\DiscriminatorMap(['per' => 'Personne', 'etu' => 'Etudiant', 'ens' => 'Enseignant'])]
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Length(
        min: 3,
        max: 40,
        minMessage: '{{ limit }} caractères au minimum',
        maxMessage: '{{ limit }} caractères au maximum'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Regex(
        pattern: '/\d/',
        match: false,
        message: 'Ce champ ne doit pas contenir de chiffres'
    )]
    private ?string $prenom = null;

    #[ORM\OneToOne(inversedBy: 'personne', cascade: ['persist', 'remove'])]
    private ?Adresse $adresse = null;

    #[ORM\OneToMany(mappedBy: 'personne', targetEntity: Commentaire::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $commentaires;

    #[ORM\ManyToMany(targetEntity: Sport::class, mappedBy: 'personnes', cascade: ['persist'])]
    private Collection $sports;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->sports = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPersonne($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPersonne() === $this) {
                $commentaire->setPersonne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sport>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): static
    {
        if (!$this->sports->contains($sport)) {
            $this->sports->add($sport);
            $sport->addPersonne($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): static
    {
        if ($this->sports->removeElement($sport)) {
            $sport->removePersonne($this);
        }

        return $this;
    }




}
