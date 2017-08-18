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
		 
		return $this->render('List.twig',array('jobs' => $jobs));
    }
    
    /**
    * @Route("/api/jobs/{status}", defaults={"status" = "all"})
    */
    public function jobsAction($status)
    {
        $querybuilder =  $this->getDoctrine()->getRepository('AppBundle:Job')
            ->createQueryBuilder('j')
            ->select('j.name, j.author');
        if($status=="edit") $querybuilder->where('j.finalized = false');
        else if ($status=="finalized") $querybuilder->where('j.finalized = true')->where('j.finished = false');
        else if ($status=="finished") $querybuilder->where('j.finished = true');
		return new JsonResponse($querybuilder->getQuery()->getResult());
    }
}

?>
