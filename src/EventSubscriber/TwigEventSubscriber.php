<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TwigEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private Environment $twig, private RecipeRepository $recipeRepository)
    {
    }

    public function onControllerEvent(ControllerEvent $event): void
    {
        $this->twig->addGlobal('recipes', $this->recipeRepository->findAll());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
