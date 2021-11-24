<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Work;
use App\Entity\Genre;
use App\Entity\Person;
use App\Form\FilmType;
use App\Form\WorkType;

use App\Form\SearchWorkType;
use App\Entity\Search\SearchWork;
use App\Repository\WorkRepository;
use App\Repository\ActivityRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use App\Serializer\Normalizer\WorkNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function home(Request $request) {
        $repo = $this->getDoctrine()->getRepository(Work::class);

        $works = $repo->findAll();
        return $this->render('film/home.html.twig', [
        'controller_name' => 'FilmController',
            'works' => $works
    ]);
    }

     /**
    * @Route("/statistics", name="statistics")
    */
    public function statistics(Request $request) {
        $repo = $this->getDoctrine()->getRepository(Work::class);

        $works = $repo->findAll();
        return $this->render('statistics.html.twig', [
        'controller_name' => 'FilmController',
            'works' => $works
    ]);
    }

    /**
     * @Route("/film", name="film")
     */
    public function index(Request $request, PaginatorInterface $paginator, WorkRepository $repository)
    {       
        
        
        $searchData = new SearchWork();
        $searchForm = $this->createForm(SearchWorkType::class, $searchData);
        
        $searchForm->handleRequest($request);

        $worksAll = $repository->findByCriteria($searchData);
        $works = $paginator->paginate(
            $worksAll,
            $request->query->getInt('page', 1),
            25
            );

        if($request->query->get('id')){
                $dossier = $request->query->get('id');
                return $this->render('film/index.html.twig', [
                    'controller_name' => 'FilmController',
                    'works' => $works,
                    'searchForm' => $searchForm->createView(),
                    'dossier' => $dossier,
                ]);
            }
        else {
            return $this->render('film/index.html.twig', [
                'controller_name' => 'FilmController',
                'works' => $works,
                'searchForm' => $searchForm->createView()
            ]);
        }
        
    }
    
    

    /**
    *  
    *  @Route("/film/{id}/edit", name="film_edit")
    *  @Route("/film/new", name="film_create")
    */
    public function create(Work $work = null, Request $request, ObjectManager $manager) {

        $dossier = $request->query->get('id');

        if($work != null){
            $worktype = $work->getType();
        }
        else{
            $worktype = "Film";
            $work = new Film;
            $work->status = "New";
        }
        
        $form = $this->createForm(WorkType::class, $work, array(
            'workType' => $worktype,
        ));
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($work);
            $manager->flush();

            if($dossier){

                return $this->redirectToRoute('project_add_work', [ 'id' => $dossier , 'work' => $work->getId() ]);
            }

            return $this->redirectToRoute('film');
        }
       
    return $this->render('film/create.html.twig', [
        'form' => $form->createView()
    ]);
    }

     /**
     * @Route("/film/{id}", name="film_view")
     */
    public function detail(Request $request, Work $work, ActivityRepository $activities)
    {

        $activitiesAll = $activities->findByWork($work->getid());
        return $this->render('film/view.html.twig', [
            'controller_name' => 'FilmController',
            'work' => $work,
            'activities' => $activitiesAll
        ]);
    }

    /**
    * @Route("/test", name="test")
    */
    public function test() {
        $token  = new \Tmdb\ApiToken('809df446f9ffd1e82b2d84cfbbddd7df');
        $client = new \Tmdb\Client($token, ['secure' => false]);
                $repository = new \Tmdb\Repository\PeopleRepository($client);
        $movie      = $repository->load(2219660);

        dd($movie);

       /* //$movie->getTitle(); 
        return $this->render('film/home.html.twig',
        ['movie'=>$movie]);    */        
       /*http://image.tmdb.org/t/p/w300_and_h450_bestv2/gEBWt6ypz6JuoceiVFcyl35kBSY.jpg/     */   

    }

    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
                ->setAction($this->generateUrl('handle_search'))
                ->add("query", TextType::class, [
                    'attr' => [ 
                        'placeholder'   => 'Enter search query...'
                    ]
                ])
                ->add("result", CollectionType::class,[
                    'attr' => [
                        'label' => '',
                    ]
                ])
            ->getForm()
        ;

        return $this->render('search/search.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch/{query?}", name="handle_search", methods={"POST", "GET"})
     */
    public function handleSearchRequest(Request $request, $query)
    { 
        $em = $this->getDoctrine()->getManager();

        if ($query)
        {
            $data = $em->getRepository(Work::class)->findByTitle($query);
        } else {            
            $data = $em->getRepository(Work::class)->findBy(array(),array(),100,null);
        }
        dump($data);
       
        // setting up the serializer 
       
        $encoders =  [
            new JsonEncoder()
        ];
        
        /*$defaultContext =[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitle();
            }
        ];*/

        $normalizers = [
            new WorkNormalizer()
        ];
        

        $serializer = new Serializer($normalizers, $encoders);

        /*$jsonObject = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function($data) {
                return $data->getId();
            }
        ]);*/
        
        return $this->json($data, 200, [], [
            ObjectNormalizer::IGNORED_ATTRIBUTES => ['crew'],
        ]);
    }   

}
