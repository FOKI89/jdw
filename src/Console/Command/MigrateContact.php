<?php

namespace Console\Command;

use AppBundle\Entity\Contact;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateContact extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('migrate_contact')
            ->setDescription('Migrate contact');
    }

    private function _connectToOldDb()
    {
        $dbName = $this->getContainer()->getParameter('old_database_name');
        $host = $this->getContainer()->getParameter('old_database_host');
        $user = $this->getContainer()->getParameter('old_database_user');
        $password = $this->getContainer()->getParameter('old_database_password');

        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host;

        $pdo = new PDO($dsn, $user, $password);
        return $pdo;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pdo = $this->_connectToOldDb();

        $statement = $pdo->prepare('SELECT nom, prenom, id_titre, genre FROM contact');
        $statement->execute();
        $oldContacts = $statement->fetchAll();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $nbContacts = count($oldContacts);
        $progress = new ProgressBar($output, $nbContacts);
        $progress->start();
        foreach ($oldContacts as $oldContact) {
            $contact = new Contact();
            $contact->setUserId(1);
            $contact->setFirstName($oldContact['prenom']);
            $contact->setLastName($oldContact['nom']);
            $contact->setTitleId($oldContact['id_titre']);
            $contact->setGender($oldContact['genre']);
            $contact->setCountry('');
            $em->persist($contact);
            $progress->advance();
        }
        $em->flush();
        $progress->finish();
    }
}