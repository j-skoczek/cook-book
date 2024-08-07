<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', NULL, ['label' => 'recipe name'])
            ->add(
                'ingredients_string',
                TextType::class,
                [
                    'label' => 'comma separated list of ingredients',
                    'mapped' => false
                ]
            )
            ->add('recipe')
            ->add(
                'picture',
                FileType::class,
                [
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [
                        new Image(['maxSize' => '1024k'])
                    ]
                ]
            )
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
