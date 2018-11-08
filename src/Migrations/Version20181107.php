<?php

namespace DoctrineMigrations;

use App\Entity\Adresse;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version20181107 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const Adresse = [
        ['9 rue Charles Coulomb', 'ZA ARAGO', "28000", "Chartres"],
        ['61 boulevard Charles Peguy', '', "28000", "Chartres"],
        ['12 rue des Lilas', '', "28110", "Lucé"],
    ];

    public function preUp(Schema $schema) {
        $this->em = $this->container->get('doctrine.orm.entity_manager');
    }

    public function up(Schema $schema)
    {
        foreach (self::Adresse as $key => $value) {
            $adresse = new Adresse();
            $adresse->setAdresse1($value[0]);
            $adresse->setAdresse2($value[1]);
            $adresse->setCodePostal($value[2]);
            $adresse->setVille($value[3]);

            $this->em->persist($adresse);
        }
        $this->em->flush();
    }

    public function down(Schema $schema)
    {
        // TODO: Implement down() method.
    }

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;
    }
}