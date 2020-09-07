<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Work;
use App\Entity\Crew;
use App\Entity\Film;
use App\Repository\CrewRepository;
use App\Form\WorkType;
use App\Form\FilmType;

class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="film")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Work::class);

        $works = $repo->findAll();

        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'works' => $works
        ]);
    }
    /**
    * @Route("/", name="home")
    */
    public function home() {
        $repo = $this->getDoctrine()->getRepository(Work::class);

        $works = $repo->findAll();
        return $this->render('film/home.html.twig', [
        'controller_name' => 'FilmController',
            'works' => $works
    ]);

    }

    /**
    *  @Route("/film/new", name="film_create")
    *  @Route("/film/{id}/edit", name="film_edit")
    */
    public function create(Work $work = null, Request $request, ObjectManager $manager, CrewRepository $crewRepository) {
        

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
        $client = new \Tmdb\Client($token);
                $repository = new \Tmdb\Repository\MovieRepository($client);
        $movie      = $repository->load(5503);
        
        //$movie->getTitle(); 
        return $this->render('film/home.html.twig',
        ['movie'=>$movie]);            
                

    }

}
