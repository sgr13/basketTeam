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
        if (!$this->getUser()) {
            return $this->redirect('/login');
        }
        
        $playersList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findAll();
        $playerExists = ($this->getUser()->getPlayer() == null ? 0 : 1);
        $playerCheckedIn = $this->getDoctrine()->getRepository('BasketballBundle:Player')->checkIfPlayerIsCheckedIn($this->getUser(), $playersList);
        
        return $this->render('BasketballBundle:Main:main_page.html.twig', array(
            'playerCheckedIn' => $playerCheckedIn,
            'playerExists' => $playerExists
        ));
    }

}
