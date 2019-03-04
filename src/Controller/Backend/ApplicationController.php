<?php

namespace App\Controller\Backend;

use App\Components\UniqueIdGenerator;
use App\Entity\Application;
use App\Form\ApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Application controller.
 * @Route("/backend/apps")
 */
class ApplicationController extends AbstractController
{
    /**
     * Lists all application entities.
     *
     * @Route("/", name="backend_apps_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository(Application::class)->findAll();

        return $this->render('application/index.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Creates a new application entity.
     *
     * @Route("/new", name="apps_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($application->getApiKey() === null){
                $application
                    ->setApiKey((new UniqueIdGenerator())->generateUniqueId())
                    ->setUser($this->getUser());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('apps_edit', array('id' => $application->getId()));
        }

        return $this->render('AppBundle:application:new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing application entity.
     *
     * @Route("/{id}/edit", name="apps_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Application $application)
    {
        $editForm = $this->createForm('App\Form\ApplicationType', $application);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('apps_edit', array('id' => $application->getId()));
        }

        return $this->render('application/edit.html.twig', array(
            'application' => $application,
            'form' => $editForm->createView()
        ));
    }

    /**
     * Deletes an application entity.
     *
     * @Route("/{id}/delete", name="apps_delete", methods={"GET"})
     */
    public function deleteAction(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(Application::class);

        $application = $repo->find($id);

        if($application !== null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();
        }

        return $this->redirectToRoute('apps_index');
    }
}
