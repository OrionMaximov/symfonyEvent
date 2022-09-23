<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function editevent(ObjectManager $om, Request $request, Event $event=null,SluggerInterface $slugger){
        if(!$event){
            $event = new Event();
        }
        $formulaire = $this->createForm(EventType::class, $event);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid()){
            /**
            * @var UploadedFile $imageFile
            */ 
            
            $imageFile=$formulaire->get('Picture')->getData(); // si erreur changé image en picture
            if($imageFile){
               
                $originalFilename= pathinfo($imageFile->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename=$slugger->slug($originalFilename);
                $newFilename= $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try{
                    $imageFile->move($this->getParameter('dossierImages'),$newFilename);
                }catch(FileException $e){
                    $e->getMessage();
                }
                $event->setPicture($newFilename);
            }
            $om->persist($event);
            $om->flush();
            return $this->redirectToRoute("app_event");
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
    /**
     * @Route("/showAll", name="app_all")
     */
    public function showAll(): Response
    {
        return $this->render('event/list.html.twig', [
            
        ]);
    }
}
