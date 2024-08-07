<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/', name: 'app_homepage')]
    public function index(
        Request $request,
        RecipeRepository $recipeRepository,
        CommentRepository $commentRepository,
        #[Autowire('%picture_dir%')] string $pictureDir
    ): Response {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($picture = $form['picture']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $picture->guessExtension();
                $picture->move($pictureDir, $filename);
                $recipe->setPictureFileName($filename);
            }
            $ingredients = explode(',', $form['ingredients_string']->getData());
            $recipe->setIngredients($ingredients);

            $this->entityManager->persist($recipe);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_recipe', ['slug' => $recipe->getSlug()]);
        }


        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $recipeRepository->getRecipePaginator($recipe, $offset);

        return $this->render('homepage/index.html.twig', [
            'recipes' => $paginator,
            'previousPage' => $offset - RecipeRepository::RECIPES_PER_PAGE,
            'nextPage' => $offset + min(count($paginator), RecipeRepository::RECIPES_PER_PAGE),
            'comments' => $commentRepository->findBy(['recipe' => $recipe], ['created' => 'DESC']),
            'recipe_form' => $form
        ]);
    }
}
