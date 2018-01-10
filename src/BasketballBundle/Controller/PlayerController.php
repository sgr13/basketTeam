<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Player;
use BasketballBundle\Form\PlayerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends Controller
{
    /**
     * @Route("/addPlayer", name="addPlayer")
     */
    public function addPlayerAction(Request $request)
    {   
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();
            $player->setGames(12);
            $user = $this->getUser();               
            $player->setUser($user);
            
            $photoFront = $player->getPhotoFront();
            $photoBack = $player->getPhotoBack();
            $pathToImg = $request->server->get('DOCUMENT_ROOT').$request->getBasePath() . '/photos';
            
             $photoFrontName = md5(uniqid()) . '.' . $photoFront->guessExtension();
             $photoBackName = md5(uniqid()) . '.' . $photoBack->guessExtension();
             
            $photoFront->move(
                $pathToImg,
                $photoFrontName
            );
             
            $photoBack->move(
                $pathToImg,
                $photoBackName
            );
            
            $player->setPhotoFront($photoFrontName);
            $player->setPhotoBack($photoBackName);
            
//            dump($player);die;
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            
            return new Response('<h1>Działa!!!</h1>');
             
        }
        
        return $this->render('BasketballBundle:Player:add_player.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/editPlayer")
     */
    public function editPlayerAction()
    {
        return $this->render('BasketballBundle:Player:edit_player.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deletePlayer")
     */
    public function deletePlayerAction()
    {
        return $this->render('BasketballBundle:Player:delete_player.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/checkIn", name="checkIn")
     */
    public function checkInAction()
    {   
        $nextGame = $this->getDoctrine()->getRepository('BasketballBundle:NextGame')->findAll();
        $dayofweek = date('w', strtotime(str_replace('.', '-', $nextGame[0]->getDate())));
        $week = array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
        $result = $week[$dayofweek - 1];
//        dump($nextGame[0]->getPlayersList());die;
        $playersList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findAll();
//        dump($playersList);die;
        $loggedUserId = $user = $this->getUser()->getId();
        foreach ($playersList as $value) {
            if ($value->getId() == $loggedUserId) {
                $playerCheckedIn = 1;
                break;
            } else {
                $playerCheckedIn = 0;
            }
        }
//        dump($playerCheckedIn);die;
        return $this->render('BasketballBundle:Player:check_in.html.twig', array(
            'nextGame' => $nextGame[0],
            'result' => $result,
            'playerCheckedIn' => $playerCheckedIn
        ));
    }

    /**
     * @Route("/checkOut")
     */
    public function checkOutAction()
    {
        return $this->render('BasketballBundle:Player:check_out.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/userPanel", name="userPanel")
     */
    public function userPanelAction() 
    {
        return $this->render('BasketballBundle:Player:user_panel.html.twig', array(
            // ...
        ));
    }

}
