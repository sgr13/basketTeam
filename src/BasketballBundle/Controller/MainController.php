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
//        dump(count($playersList));die;
        if ($this->getUser()->getPlayer() != null && count($playersList) > 0) {
//            dump('ok');die;
            $loggedPlayerId = $this->getUser()->getPlayer()->getId();
//            dump($playersList);die;
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
//        dump($playerCheckedIn);die;
        return $this->render('BasketballBundle:Main:main_page.html.twig', array(
            'playerCheckedIn' => $playerCheckedIn
        ));
    }

}
