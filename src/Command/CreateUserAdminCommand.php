<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[AsCommand(
    name: "app:create-admin",
    description: "Create a new User (Admin)",
    hidden: false
)]
class CreateUserAdminCommand extends Command
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $hasher

    )
    {
        parent::__construct();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this->setDescription("Create a new User (Admin)")
            ->addArgument("email",InputArgument::REQUIRED,"User's email")
            ->addArgument("password",InputArgument::REQUIRED,"User's password")

        ;

    }

    /**
     * @throws InvalidArgumentException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(["User creation","========"]);

        $email = $input->getArgument("email");
        $password = $input->getArgument("password");

        if($this->userRepository->findOneBy(["email" => $email])){
            $output->writeln(["User already exists","========"]);
            return Command::FAILURE;
        }


        $output->writeln("Email : ".$email);



        $user = (new User())
            ->setEmail($email)
            ->setRoles([User::ROLE_ADMIN])
        ;
        $password = $this->hasher->hashPassword($user,$password);
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        return Command::SUCCESS;




    }
}