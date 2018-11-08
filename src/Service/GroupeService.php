<?php

namespace App\Service;
use App\Entity\Groupe;
use Doctrine\ORM\EntityManagerInterface;

class GroupeService {
    public $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function updateGroupe(Groupe $groupe) {
        $this->entityManager->persist($groupe);
        $this->entityManager->flush();
    }
    
    public function deleteGroupe(Groupe $groupe) {
        $this->entityManager->remove($groupe);
        $this->entityManager->flush();
        return true;
    }  
}