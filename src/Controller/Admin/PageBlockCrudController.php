<?php

namespace App\Controller\Admin;

use App\Entity\PageBlock;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageBlockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PageBlock::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des blocks de pages')
            ->setSearchFields(['id', 'title', 'slug', 'content', 'type', 'position']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $slug = TextField::new('slug');
        $type = TextField::new('type');
        $content = TextareaField::new('content');
        $page = AssociationField::new('page');
        $position = IntegerField::new('position');
        $medias = AssociationField::new('medias');
        $id = IntegerField::new('id', 'ID');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $deletedAt = DateTimeField::new('deletedAt');
        $enabled = BooleanField::new('enabled');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $slug, $position, $type, $page, $enabled];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $slug, $content, $type, $position, $createdAt, $updatedAt, $deletedAt, $page, $medias];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $slug, $type, $content, $page, $position, $medias];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $slug, $type, $content, $page, $position, $medias];
        }
    }
}
