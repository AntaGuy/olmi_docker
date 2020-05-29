<?php

namespace App\Controller\EasyAdmin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard(EntityManagerInterface $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'usersCount' => count($users),
        ]);
    }
}
