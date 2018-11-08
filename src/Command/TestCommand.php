<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand {
    protected function configure() {
        $this->setName('captusite:exports:users')
            ->setDescription("Exporte la liste des utilisateurs")
            ->setHelp("Exporte une liste d\'utilisateurs dans un fichier csv");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        $outputConsole = new ConsoleOutput();
        $outputConsole->writeln('<info>|=== Début de la commande d\'export</info>');

        $userService = $container->get(UserService::class);
        $userService->exportUsers();
        $outputConsole->writeln('<info>|=== Fin de la commande d\'export</info>');
    }
}