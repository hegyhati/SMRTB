<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ListController
{
    
    /**
    * @Route("/list")
    */
    public function listAction()
    {
        return new Response('<html><body>List of Jobs</body></html>');
    }
}

?>
