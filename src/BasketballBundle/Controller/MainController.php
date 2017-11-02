<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/")
     */
    public function mainPageAction()
    {
        return $this->render('BasketballBundle:Main:main_page.html.twig', array(
            // ...
        ));
    }

}
