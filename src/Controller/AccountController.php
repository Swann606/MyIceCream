<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use App\Repository\RecipeLikeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
 
    /**
     * @Route("/account/{id}", name="account")
     */
    public function account(UserRepository $userRepo, RecipeRepository $recipeRepo )
    {
       
        $user = $userRepo -> findOneBy([
            'id'=>$id
            ]);

        $recipes = $recipeRepo->findBy([
            'user'=> $user
            ]);
        
        //$MyLikedRecipes = $recipeLikeRepo->findBy($user);


        return $this->render('account.html.twig', [
            'user'=>$user,
            'recipes' =>$recipes
        ]);
    }
}
