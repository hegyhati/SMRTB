<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class JobController extends Controller
{
    
    /**
    * @Route("/job/{id}", name="jobdetails")
    */
    public function detailsAction($id)
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$job=$repository->findOneById($id);
		 
		return $this->render('JobDetails.twig', array('job' => $job));
    }
    
  
    

}

?>
