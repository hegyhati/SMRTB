<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ListController extends Controller
{
    
    /**
    * @Route("/list")
    * @Method("GET")
    */
    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
		$repository=$this->getDoctrine()->getRepository('AppBundle:Job');
		$jobs=$repository->findAll();
        
        $statenumbers=[0,1,2,3,4,5];
        $states=[];
        foreach($statenumbers as $number) {
            $states[] = array(
                'number'=> $number, 
                'text'=> Job::getStringByState($number)
            );
        }
		
        return $this->render('JobSelector.twig',array('jobs' => $jobs, 'states' => $states));
    }
    
    public function jobsAction($state)
    {
        return $this->render('List.twig',array('jobs' => $this->getDoctrine()->getRepository('AppBundle:Job')->findByState($state)));
    }
    
    /**
    * @Route("/api/jobs/{state}", defaults={"state" = -1}, name="JobsAPI")
    * @Method("GET")
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
