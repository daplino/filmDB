<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Work;
use App\Form\FilmType;
use App\Form\WorkType;
use App\Form\SearchWorkType;
use App\Entity\Search\SearchWork;

use App\Repository\WorkRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'works' => $works,
            'searchForm' => $searchForm->createView()
        ]);
    }
    

    /**
    *  @Route("/film/new", name="film_create")
    *  @Route("/film/{id}/edit", name="film_edit")
    */
    public function create(Work $work = null, Request $request, ObjectManager $manager) {
        

        if($work != null){
            $worktype = $work->getType();
        }
        else{
            $worktype = "Film";
            $work = new Film;
        }
        
        $form = $this->createForm(WorkType::class, $work, array(
            'workType' => $worktype,
        ));

        

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        $manager->persist($work);
        $manager->flush();

        }
                
        return $this->render('film/create.html.twig', [
            'form' => $form->createView()
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

}
