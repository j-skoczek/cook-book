<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(
        Request $request,
        RecipeRepository $recipeRepository,
        CommentRepository $commentRepository
    ): Response {

        $recipe = new Recipe();
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $recipeRepository->getRecipePaginator($recipe, $offset);

        return $this->render('homepage/index.html.twig', [
            'recipes' => $paginator,
            'previousPage' => $offset - RecipeRepository::RECIPES_PER_PAGE,
            'nextPage' => $offset + min(count($paginator), RecipeRepository::RECIPES_PER_PAGE),
            'comments' => $commentRepository->findBy(['recipe' => $recipe], ['created' => 'DESC']),
        ]);
    }
}
