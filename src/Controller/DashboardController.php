<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Groupe;
use App\Entity\User;
use App\Service\UserService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View as CreateView;


class DashboardController extends FOSRestController {

    /**
     * @Rest\Get("/api/users", name="api_users_get")
     * @Rest\View(serializerGroups={"Default"})
     */
    public function getApiUsers() {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        //var_dump(count($users));
        return CreateView::create($users, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/users", name="api_users_post")
     * @Rest\View(serializerGroups={"Default"})
     */
    public function addApiUser(Request $request)
    {
        $user = new User();
        $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy(array("label" => $request->get('groupe')));
        $adresse = $this->getDoctrine()->getRepository(Adresse::class)->findById($request->get('adresse'));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setEmail($request->get('email'));
        $user->setPhone($request->get('phone'));
        $user->setGroupe($groupe);
        $user->addAdresse($adresse);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return CreateView::create($user, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/users/{id}", name="api_users_put")
     * @Rest\View(serializerGroups={"Default"})
     */
    public function updateApiUser(Request $request, User $user)
    {
        var_dump($request->get('firstname'));
        $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy(array("label" => $request->get('groupe')));
        $adresse = $this->getDoctrine()->getRepository(Adresse::class)->findById($request->get('adresse'));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setEmail($request->get('email'));
        $user->setPhone($request->get('phone'));
        $user->setGroupe($groupe);
        //$user->addAdresse($adresse);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return CreateView::create($user, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/users/{id}", name="api_users_delete")
     * @Rest\View(serializerGroups={"Default"})
     */
    public function deleteApiUser(UserService $userService, User $user)
    {
        $userService->deleteUser($user);
        return CreateView::create("OKAY !", Response::HTTP_OK);
    }

}