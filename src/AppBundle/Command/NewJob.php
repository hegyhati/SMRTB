<?php

namespace AppBundle\Command;

use AppBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class NewJob extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:new-job')

        // the short description shown while running "php bin/console list"
        ->setDescription('Adds a new Job')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to add a new Job to the database...')
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $job = new Job();
        $helper = $this->getHelperSet()->get('question');

        $job->setName($helper->ask($input, $output, 
            new Question('<info>Name of the Job:</info> ', 'TestJob')));
        
        $job->setAuthor($helper->ask($input, $output, 
            new Question('<info>Author of the Job:</info> ', 'TestJob')));
        
        $job->setInputFile($helper->ask($input, $output, 
            new Question('<info>Input:</info> ', 'alma,korte,banan,barack')));
        
        $job->setFinalized($helper->ask($input, $output, 
            new ConfirmationQuestion('<info>Is the job finalized?</info> ', false)));
        
        $job->setFinished($helper->ask($input, $output, 
            new ConfirmationQuestion('<info>Is the job finished?</info> ', false)));
        
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository("AppBundle:Job");
        
        $em->persist($job);
        $em->flush();
        
    }
}

?>