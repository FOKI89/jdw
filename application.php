<?php
use Console\Command\MigrateContact;

require __DIR__.'/vendor/autoload.php';

$command = new MigrateContact();
$kernel = new AppKernel('dev', true);
$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->add($command);
$application->add(new \Console\Command\CreateClient());
$application->run();