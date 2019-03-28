<?php

declare(strict_types=1);

namespace App\AMS\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class Recipe extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true, 'label' => 'Recipe name', 'attr' => ['placeholder' => 'Enter recipe name']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('prep', IntegerType::class, [
                'label' => 'Preparation time (minutes)', 'attr' => ['placeholder' => 'Enter preparation time in minutes']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('cook', IntegerType::class, [
                'label' => 'Cooking time (minutes)', 'attr' => ['placeholder' => 'Enter cooking time in minutes']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('author', TextType::class, [
                'label' => 'Author', 'attr' => ['placeholder' => 'Enter recipe author ']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('imageLink', TextType::class, [
                'label' => 'Cooking time (minutes)', 'attr' => ['placeholder' => 'Cooking time in minutes']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('cook', IntegerType::class, [
                'label' => 'Cooking time (minutes)', 'attr' => ['placeholder' => 'Cooking time in minutes']
            ] )->setAttributes(['class' => 'input-group'])

            ->add('search', SubmitType::class, ['attr' => ['class' => 'btn-lg btn-primary rounded float-right'] ])
        ;
    }
}
