<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\ColorType;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\RecipeType;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
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

    // 

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
            if (!$recipe->getId()){
                $recipe->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
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
    public function recipeDatasheet(Recipe $recipe)
    {
        return $this->render('home/recipe.html.twig', [
            'recipe' => $recipe
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



}
