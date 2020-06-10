<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Work;

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
        return $this->render('film/home.html.twig');

    }

    /**
    *  @Route("/film/new", name="film_create")
    *  @Route("/film/{id}/edit", name="film_edit")
    */
    public function create(Work $work = null, Request $request, ObjectManager $manager) {

        $form = $this->createFormBuilder($work)
                     ->add('title')
                     ->add('yearOfCopyright')
                     ->add('id')
                     ->add('save', SubmitType::class)
                     ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        $manager->persist($work);
        $manager->flush();

        }
                     
        return $this->render('film/create.html.twig', [
            'formFilm' => $form->createView()
        ]);
    }

}
