<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Recipe;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recipe/{id}', name: 'app_recipe')]
    public function show(Recipe $recipe, CommentRepository $commentRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipe' => $recipe,
            'comments' => $commentRepository->findBy(['recipe' => $recipe], ['created' => 'DESC']),
        ]);
    }
}
