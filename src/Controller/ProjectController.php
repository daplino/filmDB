<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Form\SearchProjectType;
use App\Entity\Search\SearchProject;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(ProjectRepository $repository, Request $request, PaginatorInterface $paginator)
    {

        $searchData = new SearchProject();
        $searchForm = $this->createForm(SearchProjectType::class, $searchData);
        
        $searchForm->handleRequest($request);
        $projectsAll = $repository->findByCriteria($searchData);
        $projects = $paginator
                    ->paginate(
                        $projectsAll,
                        $request->query->getInt('page', 1),
                        25
                    )
        ;
        
        
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects,
            'searchForm' => $searchForm->createView()
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
