<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Comment;
use App\Form\RecipeType;
use App\Form\CommentType;

use App\Entity\RecipeLike;

use App\Repository\RecipeRepository;

use App\Repository\RecipeLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function home(RecipeRepository $recipeRepo, RecipeLikeRepository $recipeLikeRepo)
    {
        $lastRecipes = $recipeRepo->findLatest();


        $popularRecipes=$recipeRepo->findMostPopular();
   

        return $this->render('home/home.html.twig', [
            'lastRecipes' => $lastRecipes,
             'popularRecipes' => $popularRecipes
        ]);
    }


     /**
     * @Route("/catalog", name="catalog")
     */
    public function catalog(RecipeRepository $repo)
    {
        $recipes = $repo->findAll();

        return $this->render('home/catalog.html.twig', [
            'recipes'=>$recipes
        ]);
    }



    /**
     * @Route("/recipe/create", name="create_recipe")
     * @Route("/recipe/{id}/edit", name="edit_recipe")
     */
    public function formRecipe( Recipe $recipe = null,  Request $request , EntityManagerInterface $manager )
    {   
          if (!$recipe){

            $recipe = new Recipe();

        } 

                /* $form = $this   ->createFormBuilder($recipe)
                        ->add('title')
                        ->add('color', ColorType::class)
                        ->add('ingredients')
                        ->add('description')
                        ->getForm(); */

        $form = $this ->createForm(RecipeType::class, $recipe);

        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $user = $this -> getUser();

            if (!$recipe->getId()){

                $recipe ->setCreatedAt(new \DateTime())
                        ->setUser($user);
            }

            $manager->persist($recipe);
            $manager->flush();

            return $this->redirectToRoute('recipeDatasheet', ['id' => $recipe->getId()]);
        }
 
        return $this->render('home/form_recipe.html.twig', [ 
            'formRecipe' => $form -> createView(),
            'editMode' => $recipe->getId() !== null
        ]);
    }


    /**
     * @Route("/recipe/{id}", name="recipeDatasheet")
     */
    public function recipeDatasheet(Recipe $recipe, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this -> getUser();
           
            $comment->setCreatedAt(new \DateTime())
                    ->setRecipe($recipe)
                    ->setAuthor($user -> getUsername());


            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('recipeDatasheet', ['id'=>$recipe->getId()]);

        }

        return $this->render('home/recipe.html.twig', [
            'recipe' => $recipe,
            'commentForm' => $form->createView()
        ]);
    }

    //égale à ça -->
/*     public function recipeDatasheet($id)
    {
        $repo = $this->getDoctrine()->getRepository(Recipe::class);

        $recipe= $repo->find($id);
        return $this->render('home/recipe.html.twig', [
            'recipe' => $recipe
        ]);
    } */



    /**
     * Permet de liker et unliker un article 
     * 
     * @Route("/recipe/{id}/like", name="recipe_like")
     *
     * @param Recipe $recipe
     * @param EntityManagerInterface $manager
     * @param RecipeLikeRepository $recipeLikerepo
     * @return Response
     */
    public function like (Recipe $recipe, EntityManagerInterface $manager, RecipeLikeRepository $recipeLikeRepo ): Response{
        
        $user = $this -> getUser();

        if(!$user){
            
            return $this->json([
            'code' => 403,
            'message' => "Unauthorised"
            ],403);
        }

        if($recipe->isLikedByUser($user)) {
            $recipeLike = $recipeLikeRepo->findOneBy([
                'recipe' => $recipe,
                'user' => $user
            ]);
            
            $manager->remove($recipeLike);
            $manager->flush();
            
            return $this->json([
                'code' => 200,
                'message' => "Like bien supprimé",
                'recipelikes' => $recipeLikeRepo->count(['recipe' =>$recipe])
            ],200);
        }
       
        $recipeLike = new RecipeLike();
        $recipeLike ->setRecipe($recipe)
                    ->setUser($user);

        $manager->persist($recipeLike);
        $manager->flush();

        return $this->json([
            'code' =>200,
            'message' => 'Like bien ajouté',
            'recipeLikes' => $recipeLikeRepo->count(['recipe' => $recipe])
        ],200);

    }

    
    /**
     * 
     * permet de supprimer le requete sélectionnée
     * 
    * @Route("/recipe/{id}/delete", name="recipeDelete")
    */
    public function removeRecipe(Recipe $recipe, EntityManagerInterface $manager)
    {
        //ajouter vérification avant
        $manager->remove($recipe);
        $manager->flush();

        return $this->redirectToRoute('account');
    }

}
