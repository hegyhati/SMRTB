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
        
        ->addArgument('testinput', InputArgument::OPTIONAL, 'Creating some built-in test jobs.')
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository("AppBundle:Job");
        
        $test = $input->getArgument('testinput');
        
        if (! $test ) {
            $job = new Job();
            $helper = $this->getHelperSet()->get('question');

            $job->setName($helper->ask($input, $output, 
                new Question('<info>Name of the Job:</info> ', 'TestJob')));
            
            $job->setAuthor($helper->ask($input, $output, 
                new Question('<info>Author of the Job:</info> ', 'TestJob')));
            
            $job->setInputFile($helper->ask($input, $output, 
                new Question('<info>Input:</info> ', 'alma,korte,banan,barack')));
            
            $job->setState($helper->ask($input, $output, 
                new Question('<info>What is the state? (0-4) </info> ', 0)));
            
            $em->persist($job);
        } 
        if ($test=="abc" || $test == "all") {
            $jobabc = new Job();
            $jobabc
                ->setName("Character counter")
                ->setAuthor("Anonymus")
                ->setInputFile("adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfserg")
                ->setState(1)
                ->setMapFunction("function map(inputchunk){var mapoutput=[];for(i=0;i<inputchunk.length;i++) mapoutput.push({key: inputchunk[i], value: 1});return mapoutput;}")
                ->setReduceFunction("function reduce(key, array){var sum=0; for(i in array) sum+=parseInt(array[i]); return {key: key, value: sum};}")
                ;
            $em->persist($jobabc);
        } 
        if ($test=="abc-large" || $test == "all") {
            $jobabcl = new Job();
            $jobabcl
                ->setName("Character counter larger")
                ->setAuthor("Anonymus")
                ->setInputFile("adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789")
                ->setState(1)
                ->setMapFunction("function map(inputchunk){var mapoutput=[];for(i=0;i<inputchunk.length;i++) mapoutput.push({key: inputchunk[i], value: 1});return mapoutput;}")
                ->setReduceFunction("function reduce(key, array){var sum=0; for(i in array) sum+=parseInt(array[i]); return {key: key, value: sum};}")
                ;
            $em->persist($jobabcl);
        }
        if ($test=="abc-huge" || $test == "all") {
            $jobabcl = new Job();
            $jobabcl
                ->setName("Character counter huge")
                ->setAuthor("Anonymus")
                ->setInputFile("adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789adf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergadf,sdfg,gs,rg,sgfg,sgs,sfd,g,fdg,gerer,gsdfsergregsgbdjnyu,uyjitoirehwbgnun,upoierogiweiughjev,wogjweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789,jweguheirguhijfvijv,zxcvbnmmmmmmmmmmmmm,lkjhgfdsa,qwertyuiopo,123456789")
                ->setState(1)
                ->setMapFunction("function map(inputchunk){var mapoutput=[];for(i=0;i<inputchunk.length;i++) mapoutput.push({key: inputchunk[i], value: 1});return mapoutput;}")
                ->setReduceFunction("function reduce(key, array){var sum=0; for(i in array) sum+=parseInt(array[i]); return {key: key, value: sum};}")
                ;
            $em->persist($jobabcl);
        }
        
        $em->flush();        
    }
}

?>
