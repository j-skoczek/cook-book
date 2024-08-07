<?php

namespace App\EventListener;

use App\Entity\Recipe;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

// #[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Recipe::class)]
// #[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Recipe::class)]
final class RecipeEntityListener
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function prePersist(Recipe $recipe, LifecycleEventArgs $event)
    {
        $recipe->computeSlug($this->slugger);
    }

    public function preUpdate(Recipe $recipe, LifecycleEventArgs $event)
    {
        $recipe->computeSlug($this->slugger);
    }
}
