<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use AppBundle\Entity\MapJob;
use AppBundle\Entity\IntermediatePair;
use AppBundle\Entity\ReduceJob;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

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
                }
            case 3:    
                    $intermediatepairs = $job->getIntermediatepairs();
                    $keys = [];
                    foreach($intermediatepairs as $pair){
                        $keys[]=$pair->getKey();
                    }
                    $keys = array_unique($keys);
                    
                    foreach($keys as $keykey => $key) {
                        $reducejob  = new ReduceJob();
                        $reducejob
                            ->setJob($job)
                            ->setFinished(false)
                            ->setKey($key);
                        foreach($intermediatepairs as $pair){
                            if($pair->getKey()==$key) {
                                $reducejob->addIntermediatepair($pair);
                                $pair->setReducejob($reducejob);
                            }
                        }
                        $em->persist($reducejob);
                    }
                    $em->flush();       
                    $job->setState(4);
                    $em->flush();
                
            case 4: // Reduce jobs running
                $reducerepository=$this->getDoctrine()->getRepository('AppBundle:ReduceJob');
                $reducejob = $reducerepository->findOneBy(array(
                    'finished' => false, 
                    'worker' => ""
                ));
                if($reducejob) {
                    $data['reducejobid'] = $reducejob -> getId();
                    $data['reducekey'] = $reducejob -> getKey();
                    $data['values'] = $reducejob -> getValues();
                    break;
                } else {
                    $job->setState(5);
                    $em->flush();                    
                }
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
        else if($jobdata['state'] == 4) return $this->render(
            'ReduceJob.twig', 
            array('job' => $job,'reducedata' => $jobdata));
        else return $this->redirectToRoute('jobdetails', array('id' => $id));
    }
    
    /**
    * @Route("/api/mapresult/{jobid}/{mapjobid}", name="mapresultAPI")
    * @Method("POST")
    */
    public function mapResultAction($jobid,$mapjobid)
    {   
        $em=$this->getDoctrine()->getManager();
        $jrepository=$this->getDoctrine()->getRepository('AppBundle:Job');   
        $mrepository=$this->getDoctrine()->getRepository('AppBundle:MapJob');
        $prepository=$this->getDoctrine()->getRepository('AppBundle:IntermediatePair');  
        
        $request = Request::createFromGlobals();
        $json = json_decode($request->getContent());
        
        $worker = $json->worker;
        $results = $json->results;
        $job = $jrepository->findOneById($jobid);
        $mapjob = $mrepository->findOneById($mapjobid);
        foreach ($results as $result) {
            $pair = new IntermediatePair();
            $pair
                ->setJob($job)
                ->setMapjob($mapjob)
                ->setKey($result->key)
                ->setValue($result->value);
            $em->persist($pair);
        }
        $mapjob
            ->setFinished(true)
            ->setWorker($worker);
        $em->flush();
        
        return new JsonResponse($this->mapreduceJSON($jobid));
    }
    
    /**
    * @Route("/api/reduceresult/{jobid}/{reducejobid}", name="reduceresultAPI")
    * @Method("POST")
    */
    public function reduceResultAction($jobid,$reducejobid)
    {   
        $em=$this->getDoctrine()->getManager();
        $jrepository=$this->getDoctrine()->getRepository('AppBundle:Job');   
        $rrepository=$this->getDoctrine()->getRepository('AppBundle:ReduceJob');
        
        $request = Request::createFromGlobals();
        $json = json_decode($request->getContent());
        
        $worker = $json->worker;
        $result = $json->result;
        $job = $jrepository->findOneById($jobid);
        $reducejob = $rrepository->findOneById($reducejobid);
        $reducejob
            ->setFinished(true)
            ->setWorker($worker)
            ->setResult($result->value);
        $em->flush();
        
        return new JsonResponse($this->mapreduceJSON($jobid));
    }
    

}

?>
