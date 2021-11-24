<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Project;
use App\Entity\Activity;
use App\Form\ProjectType;
use App\Form\ActivityType;
use App\Form\SearchProjectType;
use App\Repository\WorkRepository;
use App\Entity\Config\ConfigProject;
use App\Entity\Search\SearchProject;
use App\Repository\ActionRepository;
use App\Repository\CompanyRepository;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
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
    public function create(Project $project = null, Request $request, ObjectManager $manager, CompanyRepository $companyRepository, ActionRepository $actionRepository) {

        if($project != null){
            dump($project);
        }

        else{
            
            $project = new Project;
            $project->setStatus('new');
            $company = $companyRepository->findAll();
            $project->setCompany($company[1]);
            $action = $actionRepository->findAll();
            $project->setAction($action[1]);
            $manager->persist($project);
            $manager->flush();
           
        }
 
        $form = $this->createForm(ProjectType::class, $project);
        dump($project);
        $form->handleRequest($request);
        
        if($form->isSubmitted() ){
        $manager->persist($project);
        $manager->flush();

        }    
        return $this->render('project/create.html.twig', [
            'form' => $form->createView(),
            'projectid' => $project->getId()
        ]);
    }

    /**
    *  
    *  @Route("/project/{id}/add/{work}", name="project_add_work")
    */
    public function addWork(Project $project = null, Request $request, ObjectManager $manager, WorkRepository $repository) {

        if($project != null){
            $type = "Admission";
            $currentWork = $repository->findOneById($request->attributes->get('work'));
            $activity = new Activity();
            $activity->setWork($currentWork);
            $activity->setType($type);  
            $project->addActivity($activity);
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('project_edit', [ 'id' => $project->getId(), 'project' => $project]);

        }

        else{
            
            //do something there
           
        }
 
        
        
        
    }

    /**
     * @Route("/handleAction/{query?}", name="handle_action", methods={"POST", "GET"})
     */
    /*public function AjaxActivity(ObjectManager $manager, $query, Request $request)
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
        ]));
        $activities[]=$activity;
        
    }
    return $this->json($activitiesConfig, 200, [],[]);
        
    
    }*/

     /**
     * @Route("/handleActionVue/{query?}", name="handle_action_vue", methods={"GET"})
     */
    public function VueActivity(ObjectManager $manager, $query, Request $request)
    {
 
    
    $activitiesConfig = $this->getDoctrine()->getRepository(ConfigProject::class)->findBy(array('action'=> $query), null, 10, $offset = null);
   
    return $this->json($activitiesConfig, 200, [],[]);
        
    
    }

     /**
     * @Route("/handleStatsVue/{query?}", name="handle_stats_vue", methods={"GET"})
     */
    public function VueStats(ObjectManager $manager, $query, Request $request)
    {
 
        
    $projects = $this->getDoctrine()->getRepository(Project::class)->countProjectsPerAction();
    
    return $this->json($projects, 200, [],['groups' => ['project']]);
        
    
    }

    /**
     * @Route("/vuePost/", name="vue_post", methods={"POST"})
     */
    public function VueCreateProject(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
 
    $json = $request->getContent();
    $post = $serializer->deserialize($json, Project::class, 'json');
    dump($post);
    $post->setAction($em->getRepository(Action::class)->find($post->getAction()->getCode(),null,null));

    $em->persist($post);
    $em->flush();
   
    return $this->json($post, 201, [], []);
        
    
    }

    /**
     * @Route("/vueStatsPost/", name="vue_statistics_post", methods={"POST"})
     */
    public function VueStatsPost(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
 
    $json = $request->getContent();
    $post = $serializer->deserialize($json, Project::class, 'json');
    
    $post->setAction($em->getRepository(Action::class)->find($post->getAction()->getCode(),null,null));

    $em->persist($post);
    $em->flush();
   
    return $this->json($post, 201, [], []);
        
    
    }

   
}
