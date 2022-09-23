<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="app_event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/createone", name="createone" )
     * @Route("/editevent/{id}", name="editevent")
     */   
    public function editevent(ObjectManager $om, Request $request, Event $event=null){
        if(!$event){
            $event = new Event();
        }
        $formulaire = $this->createForm(EventType::class, $event);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid()){
            $om->persist($event);
            $om->flush();
            return $this->redirectToRoute("showall", ["id"=>$event->getId()]);
        }
        $mode = false;
        if($event->getId() !== null){
            $mode = true;
        }
        return $this->render("event/createone.html.twig",[
            "formulaire" =>$formulaire->createView(),
            "mode" => $mode
        ]);
    }
}
