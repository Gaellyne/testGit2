<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Groupe;
use App\Service\AdresseService;
use App\Form\AdresseType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\WebpackEncoreBundle;


class AdresseController extends AbstractController {

    /**
    * @Route("/adresse/list", name="adresse_list")
    */
    public function getAdresse()
    {
        $adresses=$this->getDoctrine()->getRepository(Adresse::class)->findAll();
        return $this->render('Adresse/list.html.twig', array(
            'adresses' => $adresses
        ));        
    }
    
    /**
    * @Route("/adresse/add", name="adresse_add")
    */
    public function addAdresse(Request $request, AdresseService $adresseService) {

        //$groupes=$this->getDoctrine()->getRepository(Groupe::class)->findAll();
        // creates a task and gives it some dummy data for this example
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $adresse = $form->getData();
            $adresseService->updateAdresse($adresse);
            
            return $this->RedirectToRoute("adresse_list");
        }

        return $this->render('adresse/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
    * @Route("/adresse/update/{id}", name="adresse_edit")
    */
    public function updateAdresse(Request $request, AdresseService $adresseService, Adresse $adresse) {
        
        $form = $this->createForm(AdresseType::class, $adresse);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $adresseService->updateAdresse($form->getData());
            
            return $this->RedirectToRoute("adresse_list");
        }

        return $this->render('Adresse/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
    * @Route("/adresse/delete/{id}", name="adresse_delete")
    */
    public function deleteAdresse(AdresseService $adresseService, Adresse $adresse) {
        if ($adresseService->deleteAdresse($adresse)) {
            return $this->RedirectToRoute("adresse_list");
        }
    }
    /**
     * @Route("/adresse/list/groupe/{id}", name="groupe_adresse_list")
     */
    public function getAdressesByGroup(Groupe $groupe)
    {
        //$adresses=$this->getDoctrine()->getRepository(Adresse::class)->findBy(['groupe' => $groupe]);
        $adresses=$this->getDoctrine()->getRepository(Adresse::class)->getAdressesByGroup($groupe->getId());
        return $this->render('adresse/list.html.twig', array(
            'adresses' => $adresses
        ));
    }
}