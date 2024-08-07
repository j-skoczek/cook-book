<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:list-entity-listeners',
    description: 'List all registered Doctrine entity listeners',
)]
class ListEntityListenersCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Whoa!');
        // $io = new SymfonyStyle($input, $output);
        // $metaDataFactory = $this->entityManager->getMetadataFactory();
        // $allMetaData = $metaDataFactory->getAllMetadata();

        // $listeners = [];

        // foreach ($allMetaData as $metaData) {
        //     $entityListeners = $metaData->entityListeners;
        //     if (!empty($entityListeners)) {
        //         $listeners[$metaData->getName()] = $entityListeners;
        //     }
        // }

        // if (empty($listeners)) {
        //     $io->warning('No entity listeners found.');
        //     return Command::SUCCESS;
        // }

        // foreach ($listeners as $entity => $entityListeners) {
        //     $io->section("Entity: $entity");
        //     foreach ($entityListeners as $event => $listenersArray) {
        //         foreach ($listenersArray as $listener) {
        //             $io->text("Event: $event, Listener: " . $listener['class'] . "::" . $listener['method']);
        //         }
        //     }
        // }

        return Command::SUCCESS;
    }
}
