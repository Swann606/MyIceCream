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
    public function account(RecipeRepository $recipeRepo, RecipeLikeRepository $recipeLikeRepo)
    {
       
        $user = $this -> getUser();
        
        $recipes = $recipeRepo->findBy(['user'=> $user]);

        $recipeLikes = $recipeLikeRepo->findBy(['user'=> $user]);


        dump($recipeLikes);
        dump($recipes);
       


        return $this->render('account/account.html.twig', [
            'user'=>$user,
            'recipes' => $recipes]);
    }
}
