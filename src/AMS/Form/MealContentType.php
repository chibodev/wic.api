<?php

declare(strict_types=1);

namespace App\AMS\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MealContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mealContent', TextType::class, [
                'required' => true, 'label' => false, 'attr' => ['placeholder' => 'Enter meal content']
            ] )
            ->setAttributes(['class' => 'input-group'])

            ->add('search', SubmitType::class, ['attr' => ['class' => 'btn-lg btn-primary rounded float-right'] ])
        ;
    }
}
