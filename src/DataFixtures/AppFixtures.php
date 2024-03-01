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
        // Création de catégories
        $category1 = new Category();
        $category1->setName('Desserts');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Plats principaux');
        $manager->persist($category2);

        // Création d'une recette
        $recipe = new Recipe();
        $recipe->setName('Tarte aux pommes');
        $recipe->setIngredients(['pommes', 'sucre', 'pâte brisée']);
        $recipe->setInstructions('Préchauffez le four, préparez les pommes, étalez la pâte, etc.');
        $recipe->setPreparationTime(60);
        $recipe->setDifficulty('moyen');
        $recipe->setCategory($category1);
        $recipe->setIsPublic(true);
        $manager->persist($recipe);
        
        // Création d'un user
        $user = new User();
        $user->setUsername('john_doe');
        $user->setPassword('password');
        $user->setRole(['ROLE_USER']);
        $manager->persist($user);

        // Création de commentaires
        $comment1 = new Comment();
        $comment1->setContent('Délicieux, j\'ai adoré!');
        $comment1->setRecipe($recipe);
        $comment1->setCreatedAt(new \DateTimeImmutable());
        $comment1->setCommentBy($user);
        $manager->persist($comment1);

        // Création de notations
        $rating1 = new Rating();
        $rating1->setValue(5);
        $rating1->setRecipe($recipe);
        $rating1->setRatedBy($user);
        $manager->persist($rating1);

        // Enregistrez les modifications dans la base de données
        $manager->flush();
    }
}

