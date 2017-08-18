<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller
{
    
    /**
    * @Route("/list")
    */
    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$jobs=$repository->findAll();
		 
		return $this->render('List.twig',array('jobs' => $jobs));
    }
}

?>
