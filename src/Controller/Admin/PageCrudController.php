<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des pages')
            ->setSearchFields(['id', 'title', 'slug', 'description', 'intro_title', 'intro_description', 'meta_title', 'meta_description', 'position']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $introTitle = TextField::new('intro_title');
        $metaTitle = TextField::new('meta_title');
        $description = TextareaField::new('description');
        $introDescription = TextareaField::new('intro_description');
        $metaDescription = TextareaField::new('meta_description');
        $position = IntegerField::new('position');
        $pageBlocks = AssociationField::new('page_blocks');
        $id = IntegerField::new('id', 'ID');
        $slug = TextField::new('slug');
        $enabled = BooleanField::new('enabled');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $deletedAt = DateTimeField::new('deletedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $position, $enabled];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $slug, $description, $introTitle, $introDescription, $metaTitle, $metaDescription, $position, $enabled, $createdAt, $updatedAt, $deletedAt, $pageBlocks];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $introTitle, $metaTitle, $description, $introDescription, $metaDescription, $position, $pageBlocks];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $introTitle, $metaTitle, $description, $introDescription, $metaDescription, $position, $pageBlocks];
        }
    }
}
