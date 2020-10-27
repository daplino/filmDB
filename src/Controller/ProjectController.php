<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Activity;
use App\Form\ProjectType;
use App\Form\ActivityType;
use App\Form\ActivitiesType;
use App\Entity\ConfigProject;
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
    *  @Route("/project/new/", name="project_create")
    *  @Route("/project/{id}/edit", name="project_edit")
    */
    public function create(Project $project = null, Request $request, ObjectManager $manager) {

        if($request->isXmlHttpRequest()){
            dump('youpi'.$project);
        }
        else{
            $project = new Project;
           $this->newActivity($manager, null, $request);
           dump($project);
        }

        
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
    
    /**
     * @Route("/handleAction/{query?}", name="handle_action", methods={"POST", "GET"})
     */
    public function newActivity(ObjectManager $manager, $query, Request $request)
    {
 
    
    $activitiesConfig = $this->getDoctrine()->getRepository(ConfigProject::class)->findBy(array('action'=> $query), null, 10, $offset = null);
    $activities = array();

        dump($request);
    foreach($activitiesConfig as $protoActivity) {
        $activity = new Activity();
        $activityType=$protoActivity->getActivityType();
        
        $activity->setType($activityType);
        dump($activity);
        $form = $this->createForm(ActivityType::class, $activity);
        dump($form);
        /*$activity->setProject($project);
        $project->addActivity($activity);*/
        
        /*$form['scales']->add($this->createForm(ScaleType::class, $scale, [
            'auto_initialize' => false
        ]));*/
        $activities[]=$activity;
        
    }
    $form = $this->createForm(ActivitiesType::class, $activities,array(
        'activities' => $activities,
    ));
    dump($form);
    return $this->render('search/search2.html.twig', [
        'form' => $form->createView()
        
    ]);
    }
}
