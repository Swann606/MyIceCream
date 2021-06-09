<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Recipe;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecipeLikeRepository;

/**
 * @ORM\Entity(repositoryClass=RecipeLikeRepository::class)
 */
class RecipeLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="recipeLikes")
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recipeLikes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
