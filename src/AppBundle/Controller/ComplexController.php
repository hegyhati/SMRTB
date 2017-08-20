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
    * @Route("/complex/{jobid}/{workerstate}", name="complex", defaults={"jobid"= null, "workerstate"=null})
    * @Method("GET")
    */
    public function complexAction($jobid,$workerstate)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($jobid);
        $jobs=$repository->findAll();
		 
		return $this->render('Complex.twig', array('jobs'=> $jobs, 'job' => $job, 'workerstate' => $workerstate));
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
        $job -> setName("New Project");
        $em->persist($job);
        $em->flush();        
		 
		return $this->redirectToRoute('complex', array('jobid' => $job->getId(), 'workerstate'=>'edit'));
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
		 
		return $this->redirectToRoute('complex', array('jobid' => $jobid, 'workerstate'=>'edit'));
    }

   
}
?>
