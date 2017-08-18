<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
		 
		return $this->render('JobSelector.twig',array('jobs' => $jobs));
    }
    
    public function jobsAction($state)
    {
        return $this->render('List.twig',array('jobs' => $this->getDoctrine()->getRepository('AppBundle:Job')->findByState($state)));
    }
    
    /**
    * @Route("/api/jobs/{state}", defaults={"state" = -1}, name="JobsAPI")
    */
    public function jobsAPIAction($state)
    {
        $querybuilder =  $this->getDoctrine()->getRepository('AppBundle:Job')
            ->createQueryBuilder('j')
            ->select('j.name, j.author');
        if($state!=-1) $querybuilder->where('j.state = '.$state);
        return new JsonResponse($querybuilder->getQuery()->getResult());
    }
    
    

}

?>
