<?php

namespace App\Service;
use App\Entity\User;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of UserService
 *
 * @author gwenael
 */
class UserService {

    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }

    public function updateUser(User $user){
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function deleteUser(User $user){
        foreach ($user->getAdresses() as $adresse) {
            $user->removeAdresse($adresse);
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return true;
    }

    public function exportUsers() {
        $users = $this->entityManager->getRepository(User::class)->findAllUsers();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="import.csv"');
        $fp = fopen('public/csv/test.csv', 'w+');
        foreach ( $users as $line ) {
            fputcsv($fp, $line, ";");
        }
        fclose($fp);
        
    }
}