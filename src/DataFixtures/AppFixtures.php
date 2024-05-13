<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Rating;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de utilisateurs
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setPassword('password');
            $user->setRole(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

        // Enregistrement des utilisateurs en tant que références
        foreach ($users as $key => $user) {
            $this->addReference('user_' . ($key + 1), $user);
        }

        // Création de catégories
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setName('Catégorie ' . $i);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Création de recettes
        for ($i = 1; $i <= 20; $i++) {
            $recipe = new Recipe();
            $recipe->setName('Recette ' . $i);
            $recipe->setIngredients(['ingrédient ' . $i, 'ingrédient ' . ($i + 1)]);
            $recipe->setInstructions('Instructions de la recette ' . $i);
            $recipe->setPreparationTime(rand(30, 120));
            $recipe->setDifficulty('difficile');
            $recipe->setCategory($categories[rand(0, 9)]);
            $recipe->setIsPublic(true);
            $manager->persist($recipe);

            // Création de commentaires pour chaque recette
            for ($j = 1; $j <= rand(1, 5); $j++) {
                $comment = new Comment();
                $comment->setContent('Commentaire ' . $j . ' sur la recette ' . $i);
                $comment->setRecipe($recipe);
                $comment->setCreatedAt(new \DateTimeImmutable());
                $comment->setCommentBy($users[rand(0, 4)]);
                $manager->persist($comment);
            }

            // Création de notations pour chaque recette
            for ($k = 1; $k <= rand(1, 5); $k++) {
                $rating = new Rating();
                $rating->setValue(rand(1, 5));
                $rating->setRecipe($recipe);
                $rating->setRatedBy($users[rand(0, 4)]);
                $manager->persist($rating);
            }
        }

        // Enregistrez les modifications dans la base de données
        $manager->flush();
    }
}
