<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Service\UserService;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\WebpackEncoreBundle;


class UserController extends AbstractController {

    /**
    * @Route("/user/list", name="user_list")
    */
    public function getUser()
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig', array(
            'users' => $users
        ));        
    }
    
    /**
    * @Route("/user/add", name="user_add")
    */
    public function addUser(Request $request, UserService $userService) {

        //$groupes=$this->getDoctrine()->getRepository(Groupe::class)->findAll();
        // creates a task and gives it some dummy data for this example
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $userService->updateUser($user);
            
            return $this->RedirectToRoute("user_list");
        }

        return $this->render('user/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
    * @Route("/user/update/{id}", name="user_edit")
    */
    public function updateUser(Request $request, UserService $userService, User $user) {
        
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->updateUser($form->getData());
            
            return $this->RedirectToRoute("user_list");
        }

        return $this->render('User/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
    * @Route("/user/delete/{id}", name="user_delete")
    */
    public function deleteUser(UserService $userService, User $user) {
        if ($userService->deleteUser($user)) {
            return $this->RedirectToRoute("user_list");
        }
    }
    /**
     * @Route("/user/list/groupe/{id}", name="groupe_user_list")
     */
    public function getUsersByGroup(Groupe $groupe)
    {
        //$users=$this->getDoctrine()->getRepository(User::class)->findBy(['groupe' => $groupe]);
        $users=$this->getDoctrine()->getRepository(User::class)->getUsersByGroup($groupe->getId());
        return $this->render('user/list.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/user/sendmail", name="user_mail")
     */
    public function sendmail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('noreply@captusite.fr')
            ->setTo('g.busson@captusite.fr')
            ->setBody(
                $this->renderView(
                    'emails/user.html.twig'
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);
        return $this->RedirectToRoute("user_list");
    }

}