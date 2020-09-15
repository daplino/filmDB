<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Project::class);

        $projects = $repo->findAll();
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects
        ]);
    }

    /**
    *  @Route("/project/new", name="project_create")
    *  @Route("/project/{id}/edit", name="project_edit")
    */
    public function create(Project $project = null, Request $request, ObjectManager $manager) {
        

        
        $form = $this->createForm(ProjectType::class, $project);
        
        

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        $manager->persist($project);
        $manager->flush();

        }
                
        return $this->render('project/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
