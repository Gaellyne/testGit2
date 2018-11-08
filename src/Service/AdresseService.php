<?php

namespace App\Service;
use App\Entity\Adresse;
use Doctrine\ORM\EntityManagerInterface;

class AdresseService {
    public $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function updateAdresse(Adresse $adresse) {
        $this->entityManager->persist($adresse);
        $this->entityManager->flush();
    }

    public function deleteAdresse(Adresse $adresse){
        /*foreach ($adresse->getUsers() as $user) {
            $adresse->removeUser($user);
        }*/

        $this->entityManager->remove($adresse);
        $this->entityManager->flush();
        return true;
    }
}