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

class ComplexController extends Controller
{
    
    /**
    * @Route("/complex/{jobid}", name="complex", defaults={"jobid"= null}, requirements={"jobid": "\d+"})
    * @Method("GET")
    */
    public function complexAction($jobid)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($jobid);
        $jobs=$repository->findAll();
		 
		return $this->render('Complex.twig', array('jobs'=> $jobs, 'job' => $job));
    }
    
    /**
    * @Route("/complex/new/", name="complexNewJob")
    * @Method("GET")
    */
    public function complexNewJobAction()
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
        $job = new Job();
        $job 
            -> setName("New Project")
            -> setMapFunction("\n\n\t// do some code with pairs.push({key: foo, value: bar});")
            -> setReduceFunction("function reduce (key, values) {\n\tvar result;\n\n\t // do something to calculate result based on values\n\n\treturn {key: key, value: result};\n}")
            -> setInputFile("Add,some,input,separated,with,commas");
                
        $em->persist($job);
        $em->flush();        
		 
		return $this->redirectToRoute('complex', array('jobid' => $job->getId()));
    }
    
    /**
    * @Route("/complex/{jobid}/save", name="complexSaveJob")
    * @Method("POST")
    */
    public function complexSaveJobAction($jobid)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
        $request = Request::createFromGlobals();
        
        $job = $repository->findOneById($jobid);
        $job 
            -> setName($request->request->get('name'))
            -> setMapFunction($request->request->get('mapfunction'))
            -> setReduceFunction($request->request->get('reducefunction'))
            -> setInputFile($request->request->get('input'));
        $em->flush();        
		 
		return $this->redirectToRoute('complex', array('jobid' => $jobid));
    }
    
    /**
    * @Route("/complex/{jobid}/run", name="complexRunJob")
    * @Method("GET")
    */
    public function complexRunJobAction($jobid)
    {        
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($jobid);
        
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
            $em->flush();
            $job->setState(2);
            $em->flush();
        }
		
        return $this->redirectToRoute('complex', array('jobid' => $jobid));
    }
    

    /**
    * @Route("/complex/update/{jobid}", name="complexUpdate", defaults={"jobid": "all"})
    * @Method("GET")
    */
    public function complexJobUpdateAction($jobid)
    {        
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		
        $dataa=[];
        
        if($jobid != "all") {
            $job = $repository->findOneById($jobid);
            $data['id']=$job->getId();
            $data['name']=$job->getName();
            $data['state']=$job->getState();
            $data['mapcount']=$job->getMapCount();
            $data['mapdone']=$job->getMapDone();
            $data['mapprogress']=$job->getMapProgress();
            $data['reducecount']=$job->getReduceCount();
            $data['reducedone']=$job->getReduceDone();
            $data['reduceprogress']=$job->getReduceProgress();
            $dataa=$data;
        } /*else {
            $dataa=[];
            $jobs=$repository->findAll($jobid);
            foreach ($jobs as $job) {
                $data['id']=$job->getId();
                $data['name']=$job->getName();
                $data['state']=$job->getState();
                $data['mapcount']=$job->getMapCount();
                $data['mapdone']=$job->getMapDone();
                $data['mapprogress']=$job->getMapProgress();
                $data['reducecount']=$job->getReduceCount();
                $data['reducedone']=$job->getReduceDone();
                $data['reduceprogress']=$job->getReduceProgress();
                $dataa[]=$dataa;
            }
        }*/
        return new JsonResponse($dataa);
    }

   
}
?>
