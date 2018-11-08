<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Service\GroupeService;
use App\Form\GroupeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\WebpackEncoreBundle;


class GroupeController extends AbstractController {

    /**
    * @Route("/groupe/list", name="group_list")
    */
    public function getGroupe()
    {
        $groupes=$this->getDoctrine()->getRepository(Groupe::class)->findAll();
        return $this->render('groupe/list.html.twig', array(
            'groupes' => $groupes
        ));        
    }
    
    /**
    * @Route("/groupe/add", name="group_add")
    */
    public function addGroupe(Request $request, GroupeService $groupeService) {
        // creates a task and gives it some dummy data for this example
        $groupe = new Groupe();
        //$groupe->setGroupe('Ajouter un groupe');
        
        /*$form = $this->createFormBuilder($groupe)
        ->add('label', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Ajouter Groupe'))
        ->getForm();*/
        $form = $this->createForm(GroupeType::class, $groupe);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $groupe = $form->getData();
            $groupeService->updateGroupe($groupe);
            
            return $this->RedirectToRoute("group_list");
        }

        return $this->render('groupe/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
    * @Route("/groupe/update/{id}", name="group_edit")
    */
    public function updateGroupe(Request $request, GroupeService $groupeService, Groupe $groupe) {
        
        $form = $this->createForm(GroupeType::class, $groupe);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $groupeService->updateGroupe($form->getData());
            
            return $this->RedirectToRoute("group_list");
        }

        return $this->render('groupe/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
    * @Route("/groupe/delete/{id}", name="group_delete")
    */
    public function deleteGroupe(GroupeService $groupeService, Groupe $groupe) {
        if ($groupeService->deleteGroupe($groupe)) {
            return $this->RedirectToRoute("group_list");
        }
    }
}