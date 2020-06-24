<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Entity\Page;
use App\Entity\PageBlock;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Backoffice OLMI');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss')
            ->setTimeFormat('HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Dashboard', 'fas fa-tachometer-alt', 'admin_dashboard');

        yield MenuItem::section('Référentiel', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Clients', 'fas fa-users', User::class)->setPermission('ROLE_ADMIN');

        yield MenuItem::section('CMS', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('Pages', 'far fa-copy', Page::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Blocks', 'fas fa-columns', PageBlock::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Médias', 'far fa-image', Media::class)->setPermission('ROLE_EDITOR');

        yield MenuItem::section('Frontend', 'fas fa-folder-open');
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'homepage');
    }
}
