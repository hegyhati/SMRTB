<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use AppBundle\Entity\MapJob;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class JobController extends Controller
{
    
    /**
    * @Route("/job/{id}", name="jobdetails")
    * @Method("GET")
    */
    public function detailsAction($id)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($id);
		 
		return $this->render('JobDetails.twig', array('job' => $job));
    }
    
    /**
    * @Route("/job/{id}/run", name="jobrun")
    * @Method("GET")
    */
    public function runAction($id)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($id);
        
        if($job->getState() == 1) {
            $chunks = explode(",", $job->getInputFile());
            foreach($chunks as $chunk) {
                $mapjob = new MapJob();
                $mapjob
                    ->setJob($job)
                    ->setInputchunk($chunk)
                    ->setFinished(false);  
                $em->persist($mapjob);
            }
            $job->setState(2);
            $em->flush();
        }
		
        return $this->redirectToRoute('jobdetails', array('id' => $id));
    }
    
    /**
    * @Route("/api/job/{id}", name="JobAPI")
    * @Method("GET")
    */
    public function jobAPIAction($id)
    {
        $querybuilder =  $this->getDoctrine()->getRepository('AppBundle:Job')
            ->createQueryBuilder('j')
            ->select('j.name, j.author, j.state')
            ->where('j.id = '.$id);
        return new JsonResponse($querybuilder->getQuery()->getResult()[0]);
    }
    
    
    
    public function mapreduceJSON($id)
    {
        $data = array();
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
        $job = $repository->findOneById($id);
        
        
        switch($job->getState()){
            case 2: // Map jobs running    
                $maprepository=$this->getDoctrine()->getRepository('AppBundle:MapJob');
                $mapjob = $maprepository->findOneBy(array(
                    'finished' => false, 
                    'worker' => ""
                ));
                if($mapjob) {
                    $data['mapjobid'] = $mapjob -> getId();
                    $data['chunk'] = $mapjob -> getInputchunk();
                    break;
                } else {
                    $job->setState(3);
                    $em->flush();
                    // generate Reduce jobs
                    $job->setState(4);
                }
            case 4: // Reduce jobs running
                break;
        }
        $data['jobid'] = $id;
        $data['state'] = $job->getState();
        return $data;
    }
    
    /**
    * @Route("/api/job/{id}/mapreduce", name="mapreduceAPI")
    * @Method("GET")
    */
    public function mapreduceAPIAction($id)
    {        
        return new JsonResponse($this->mapreduceJSON($id));
    }
    
    /**
    * @Route("/job/{id}/mapreduce", name="mapreduce")
    * @Method("GET")
    */
    public function mapreduceAction($id)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
        $job = $repository->findOneById($id);
        
        
        $jobdata = $this->mapreduceJSON($id);
        if($jobdata['state'] == 2) return $this->render(
            'MapJob.twig', 
            array('job' => $job,'mapdata' => $jobdata));
        
        else return new Response($jobdata);
    }
    

}

?>
