<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration/",
     * name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        $locale = $request->getLocale();
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('security_login');

            }

        return $this->render('security/security.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route("/login", name="security_login" )
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response{
        $locale = $request->getLocale();
        $error = $authenticationUtils->getLastAuthenticationError();


        return $this->render('security/login.html.twig', [
               'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="security_logout" )
     */
    public function logout(){
       
    }
}
