<?php

namespace App\Controller\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use ReflectionClass;


class SortController extends EasyAdminController
{
    /**
     * Resorts an item using it's doctrine sortable property
     *
     * @Route("admin/sort/{entityClass}/{id}/{position}", name="easyadmin_dragndrop_sort_sort")
     * @param String $entityClass
     * @param Integer $id
     * @param Integer $position
     * @throws NotFoundHttpException
     * @throws \ReflectionException
     * @return Response
     *
     */
    public function sortAction($entityClass, $id, $position)
    {
        $entityClassNameArray = explode("\\", $entityClass);
        $entityClassName = end($entityClassNameArray);
        try {
            $rc = new ReflectionClass($entityClass);
        } catch (\ReflectionException $error) {
            throw new \ReflectionException('The class name ' . $entityClass . '  cannot be reflected.');
        }

        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository($rc->getName())->find($id);
        if ($e === null) {
            throw new NotFoundHttpException('The entity was not found');
        }
        $e->setPosition($position);
        $em->persist($e);
        $em->flush();
        return $this->redirectToRoute(
            'easyadmin',
            array(
                'action'        => 'list',
                'entity'        => $entityClassName,
                'sortField'     => 'position',
                'sortDirection' => 'ASC',
            )
        );
    }
}
