<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use PhpParser\Node\Stmt\Function_;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }


    #[Route('/affiche', name: 'affiche')]
    public function affiche(ClassroomRepository $repo)
    { 
        $class=$repo->findAll();

        return $this->render('classroom/afficher.html.twig', [
            'classroom' => $class,
        ]);

    }

    #[Route("/Ajouter",name:"Aj")]

    public function Ajouter(Request $req,ClassroomRepository $repo)
    {
        $class=new Classroom();
        $form=$this->createForm(ClassroomType::class,$class)->add('Ajouter', SubmitType::class);
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid())
        
        { 
            
            $repo->save($class,true);
             return $this->redirectToRoute('affiche');


        }

        return $this->render('classroom/ajout.html.twig', ['f'=>$form->createView()]);
    }

    #[Route('/modifier/{id}',name:'modif')]
    function update(Request $req,Classroom $classe,\Doctrine\Persistence\ManagerRegistry $doctrine):Response{

        $form=$this->createForm(ClassroomType::class,$classe)->add('modifer', SubmitType::class);

        $form->handleRequest($req);
        
         if($form->isSubmitted() && $form->isValid()){

            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('affiche'); 
        }




            return $this->render('classroom/ajout.html.twig', ['f'=>$form->createView()]);


        } 


    #[Route('supprimer/{id}',name:'supp')]
   
    function Delete(ClassroomRepository $repo,Classroom $class)
    {

       $classroom= $repo->remove($class,true);
        return $this->redirectToRoute('affiche');
        
    } 
















}

   
    









