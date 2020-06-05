<?php

namespace App\Controller\EasyAdmin;

use App\Entity\PageBlock;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminGroupType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PageBlockController extends EasyAdminController
{
    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        // get the list of choices from your application and add the form field for them
        $formBuilder
//            ->add('group', EasyAdminGroupType::class, [
//                'mapped' => false,
//                'required' => false
//            ])
            ->add(
            'type', ChoiceType::class, [
                'choices' => PageBlock::getTypes(),
            ]
        );

        return $formBuilder;
    }
}
