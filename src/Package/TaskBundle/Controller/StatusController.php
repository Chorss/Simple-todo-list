<?php

namespace Package\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Package\TaskBundle\Entity\Status;
use Package\TaskBundle\Form\Type;

/**
 * @Route("/status")
 */
class StatusController extends Controller
{
    /**
     * @Route(
     *     "/{page}",
     *     defaults={"page" = 1},
     *     requirements={"page": "\d+"},
     *     name="PackageTaskBundle:Status:Index"
     * )
     *
     * @Template
     */
    public function indexAction(Request $request, $page)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM PackageTaskBundle:Status a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, 10);

        return array(
            'pagination' => $pagination
        );
    }

    /**
     * @Route(
     *     "/view/{id}",
     *     name="PackageTaskBundle:Status:View"
     * )
     *
     * @Template
     */
    public function viewAction($id)
    {
        $status = $this->getDoctrine()->getRepository('PackageTaskBundle:Status')->find( (int)$id );

        if(is_null($status)){
            $this->addFlash('danger', 'Is null status');
            return $this->redirectToRoute('PackageTaskBundle:Status:Index');
        }
        
        return array(
            'status' => $status
        );
    }

    /**
     * @Route(
     *     "/add",
     *     name="PackageTaskBundle:Status:Add"
     * )
     *
     * @Template
     */
    public function addAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm(new Type\AddStatusType(), $status);

        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isValid())
        {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($status);
                $em->flush();
                $this->addFlash('success', 'Add status');
                return $this->redirectToRoute('PackageTaskBundle:Status:Index');
            }catch (Exception $e){
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('PackageTaskBundle:Status:Index');
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route(
     *     "/edit/{id}",
     *     name="PackageTaskBundle:Status:Edit"
     * )
     *
     * @Template
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('PackageTaskBundle:Status')->find( (int)$id );

        if(is_null($status)){
            $this->addFlash('danger', 'Is null status');
            return $this->redirectToRoute('PackageTaskBundle:Status:Index');
        }

        $form = $this->createForm(new Type\AddStatusType(), $status);
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isValid()){
            try{
                $em->persist($status);
                $em->flush();
                $this->addFlash('success', 'edit status');
                return $this->redirectToRoute('PackageTaskBundle:Status:Index');
            }catch (Exception $e){
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('PackageTaskBundle:Status:Index');
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route(
     *     "/remove/{id}",
     *     name="PackageTaskBundle:Status:Remove"
     * )
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PackageTaskBundle:Status');
        $status = $repo->find($id);

        if(is_null($status)){
            $this->addFlash('danger', 'Is null status');
            return $this->redirectToRoute('PackageTaskBundle:Status:Index');
        }

        try{
            $em->remove($status);
            $em->flush();
            $this->addFlash('success', 'Remove status');
            return $this->redirectToRoute('PackageTaskBundle:Status:Index');
        }catch (Exception $e){
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('PackageTaskBundle:Status:Index');
        }
    }
}