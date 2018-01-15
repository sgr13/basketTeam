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
        if ($this->getUser()->getPlayer() == null) {
            $playerExists = 0;
        } else {
            $playerExists = 1;
        }
        if ($this->getUser()->getPlayer() != null && count($playersList) > 0) {
            $loggedPlayerId = $this->getUser()->getPlayer()->getId();
            foreach ($playersList as $value) {
                if ($value->getPlayer()->getId() == $loggedPlayerId) {
                    $playerCheckedIn = 1;
                    break;
                } 
                $playerCheckedIn = 0;
            }
        } else {
            $playerCheckedIn = 0;
        }
        return $this->render('BasketballBundle:Main:main_page.html.twig', array(
            'playerCheckedIn' => $playerCheckedIn,
            'playerExists' => $playerExists
        ));
    }

}
