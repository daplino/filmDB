<?php

namespace App\Controller;

use App\Form\ConfigProjectType;
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
        foreach(   $configProjects as $configProject)
        {
            $form = $this->createForm(ConfigProjectType::class, $configProject);
        }

        
        
        

        return $this->render('config/index.html.twig', [
            'controller_name' => 'ConfigController',
            'configProjects' => 'configProjects'

        ]);
    }
}
