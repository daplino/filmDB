<?php

namespace App\Controller;

use App\Entity\Config\ConfigProject;
use App\Form\Config\ConfigProjectType;
use Doctrine\Persistence\ObjectManager;
use App\Form\ConfigProjectCollectionType;
use App\Repository\ConfigProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfigController extends AbstractController
{
    /**
     * @Route("/config", name="config")
     */
    public function index(ConfigProjectRepository $repository, Request $request)
    {
        $configProjects = $repository->findAll();

        return $this->render('config/index.html.twig', [
            'controller_name' => 'ConfigController',
            'configProjects' => $configProjects

        ]);
    }

     /**
    *  @Route("/config/new", name="config_create")
    *  @Route("/config/{id}/edit", name="config_edit")
    */
    public function create(ConfigProjectRepository $repository, Request $request, ObjectManager $manager) {

        $configProjects = $repository->findAll();
 
        $form = $this->createForm(ConfigProjectCollectionType::class, $configProjects);

        
                
        return $this->render('config/create.html.twig', [
            'form' => $form->createView(),
            'data_class' => null,
        ]);
    }
}
