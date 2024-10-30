<?php

namespace App\Command;

use App\Entity\Breed;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "app:create-fixtures",
    description: "Create fixtures for Type and Breed",
    hidden: false
)]
class FixturesTypeAndBreedCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(["Fixtures generation","========"]);


        $types = [
            "chien" => ["labrador"],
            "cheval" => [
                "frison",
                "pottok",
                "irish cob"
            ],
            "brebis" => [
                "mérinos",
                "solognotes"
            ],
            "cochon" => []
        ];

        foreach($types as $typeName => $breeds){
            $t = (new Type())
                ->setName($typeName)
            ;

            foreach($breeds as $breedName){
                $b = (new Breed())
                    ->setName($breedName)
                    ->setType($t)
                ;
                $this->entityManager->persist($b);
            }

            $this->entityManager->persist($t);
        }


        $this->entityManager->flush();
        return Command::SUCCESS;

    }
}