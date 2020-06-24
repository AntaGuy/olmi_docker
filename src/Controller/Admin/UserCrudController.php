<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des utilisateurs')
            ->setSearchFields(['id', 'username', 'email', 'mobile', 'phone', 'roles', 'firstName', 'lastName']);
    }

    public function configureFields(string $pageName): iterable
    {
        $panel1 = FormField::addPanel('Informations');
        $lastName = TextField::new('lastName');
        $firstName = TextField::new('firstName');
        $phone = TelephoneField::new('phone');
        $mobile = TextField::new('mobile');
        $email = EmailField::new('email');
        $panel2 = FormField::addPanel('Credentials');
        $username = TextField::new('username');
        $plainPassword = Field::new('plainPassword');
        $roles = ArrayField::new('roles');
        $id = IntegerField::new('id', 'ID');
        $password = TextField::new('password');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $deletedAt = DateTimeField::new('deletedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $lastName, $firstName, $phone, $email, $roles];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $username, $email, $mobile, $phone, $roles, $password, $firstName, $lastName, $createdAt, $updatedAt, $deletedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$panel1, $lastName, $firstName, $phone, $mobile, $email, $panel2, $username, $plainPassword, $roles];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$panel1, $lastName, $firstName, $phone, $mobile, $email, $panel2, $username, $plainPassword, $roles];
        }
    }
}
