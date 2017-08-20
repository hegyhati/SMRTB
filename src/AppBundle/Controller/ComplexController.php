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
    * @Route("/complex/{jobid}/{work}", name="complex", defaults={"jobid"= null, "work"=false})
    * @Method("GET")
    */
    public function complexAction($jobid,$work)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($jobid);
        $jobs=$repository->findAll();
		 
		return $this->render('Complex.twig', array('jobs'=> $jobs, 'job' => $job, 'work' => $work));
    }
    

   
}
?>
