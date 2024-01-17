<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create-admin',
    description: 'Cette commande permet manuellement et efficacement un compte admin',
)]
class CreateAdminCommand extends Command
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure()
    {
        $this
            ->setName('app:create-admin')
            ->setDescription('Cette commande permet manuellement et efficacement de créer un compte admin')
            ->setHelp('create-admin [Admin identifiant] [mot de passe]')
            ->addArgument('adminUID', InputArgument::REQUIRED, "L'identifiant admin")
            ->addArgument('password', InputArgument::REQUIRED, "Le mot de passe admin");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminUID = $input->getArgument('adminUID');
        $password = $input->getArgument('password');

        $admin = new User();
        $admin->setEmail($adminUID); // Remplacez 'admin' par l'identifiant souhaité
        $admin->setRoles(['ROLE_ADMIN']);

        $admin->setNom("admin");
	$admin->setPrenom("admin");
	$admin->setSexe('N');


        // Encodage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $password);
        $admin->setPassword($hashedPassword);

        // Enregistrement de l'utilisateur dans la base de données
        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $output->writeln('Admin créé avec succès');
        return 1;
    }
}