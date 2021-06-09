<?php

namespace App\Entity;

use App\Entity\Recipe;
use App\Entity\RecipeLike;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields= {"email"}, 
 *  message= "L'email est déjà utilisé" )
 * @UniqueEntity(
 *  fields= {"username"}, 
 *  message= "Ce nom est déjà pris" )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length (min="8" , minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password" , message ="Les mots de passe ne sont pas identiques")
     */
    private $password;


    /**
     * @Assert\EqualTo(propertyPath="password" , message ="Les mots de passe ne sont pas identiques")
     */
    public $confirm_password; 

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity=RecipeLike::class, mappedBy="user")
     */
    private $recipeLikes;

    /**
     * @ORM\OneToMany(targetEntity=Recipe::class, mappedBy="user")
     */
    private $recipes;

    public function __construct()
    {
        $this->recipeLikes = new ArrayCollection();
        $this->recipes = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

 /*    public function getConfirm_password(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirm_password(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    } */

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function eraseCredentials() {}
    
    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|RecipeLike[]
     */
    public function getRecipeLikes(): Collection
    {
        return $this->recipeLikes;
    }

    public function addRecipeLike(RecipeLike $recipeLike): self
    {
        if (!$this->recipeLikes->contains($recipeLike)) {
            $this->recipeLikes[] = $recipeLike;
            $recipeLike->setUser($this);
        }

        return $this;
    }

    public function removeRecipeLike(RecipeLike $recipeLike): self
    {
        if ($this->recipeLikes->removeElement($recipeLike)) {
            // set the owning side to null (unless already changed)
            if ($recipeLike->getUser() === $this) {
                $recipeLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recipe[]
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setUser($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }

        return $this;
    }
}
