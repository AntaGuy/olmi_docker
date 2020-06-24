<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'image', 'mimetype', 'alt', 'reference']);
    }

    public function configureFields(string $pageName): iterable
    {
        $reference = TextField::new('reference');
        $alt = TextField::new('alt');
        $imageFile = Field::new('imageFile');
        $pageBlock = AssociationField::new('page_block');
        $image = ImageField::new('image');
        $id = IntegerField::new('id', 'ID');
        $mimetype = TextField::new('mimetype');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $mimetype, $reference, $alt, $image];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$image];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$reference, $alt, $imageFile, $pageBlock];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$reference, $alt, $imageFile, $pageBlock];
        }
    }
}
