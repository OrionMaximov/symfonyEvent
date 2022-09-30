<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="app_registration")
     */
    public function index(ObjectManager $om,Request $request,UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {   
        $user= new User();
        $form= $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $hash =$userPasswordEncoderInterface->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $om->persist($user);
            $om->flush();
            return $this->redirectToRoute('app_login');
        }
        $mode=false;
        if($user->getEmail() !== null){
            $mode=true;
        }
        return $this->render('registration/index.html.twig', [
            "formulaire" => $form->createView(),
            'mode'=>$mode
        ]);
    }
}
