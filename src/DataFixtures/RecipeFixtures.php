<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Comment;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');


        // Créer 3 catégories 

        for ($i = 1 ; $i <=3; $i++){
            $category= new Category();
            $category->setTitle($faker->word());

            $manager -> persist($category);

            // Création de 4 à 6 recettes

            for ($j = 1; $j <= mt_rand(4,6) ; $j++){
                $recipe = new Recipe();
                $recipe     -> setTitle($faker->sentence())
                            -> setCreatedAt($faker -> dateTimeBetween('-6 months'))
                            -> setColor($faker -> hexcolor())
                            -> setIngredients($faker->paragraph())
                            -> setDescription($faker->paragraph())
                            -> setCategory($category);
                            
                $manager    ->persist($recipe);

                // On ajoute des comments
                for ($k = 1 ; $k <= mt_rand(2,5); $k++){

                    $now = new \Datetime();
                    $interval= $now->diff($recipe->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . ' days';

                    $comment = new Comment();
                    $comment    ->setAuthor($faker->name)
                                ->setContent($faker->paragraph())
                                ->setCreatedAt($faker -> dateTimeBetween($minimum))
                                ->setRecipe($recipe);

                    $manager ->persist($comment);


                }
            }

        }

        $manager->flush();
    }
}


