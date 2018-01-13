<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Player;
use BasketballBundle\Form\PlayerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BasketballBundle\Entity\PlayerList;

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
        if ($nextGame == []) {
            return $this->render('BasketballBundle:Player:check_in.html.twig', array(
            'nextGame' => 'notSet'
            ));
        }
        $dayofweek = date('w', strtotime(str_replace('.', '-', $nextGame[0]->getDate())));
        $week = array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
        $result = $week[$dayofweek - 1];
//        dump($nextGame[0]->getPlayersList());die;
        $playersList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findAll();
//        dump($playersList);die;
        $loggedPlayerId = $this->getUser()->getPlayer()->getId();
//        dump($loggedPlayerId);
//        dump($playersList);die;
        if (count($playersList) > 0) {
            foreach ($playersList as $value) {
                if ($value->getPlayer()->getId() == $loggedPlayerId) {
                    $playerCheckedIn = 1;
    //                dump($playerCheckedIn);die;
                    break;
                } else {
                    $playerCheckedIn = 0;
                }
            }
        } else {
            $playerCheckedIn = 0;
        }
        
//        dump($playerCheckedIn);die;
        return $this->render('BasketballBundle:Player:check_in.html.twig', array(
            'nextGame' => $nextGame[0],
            'result' => $result,
            'playerCheckedIn' => $playerCheckedIn
        ));
    }

    /**
     * @Route("/signInOut/{action}", name="signInOut")
     */
    public function signInOutAction($action)
    {   
        $em = $this->getDoctrine()->getManager();
        if ($action == 'signIn') {
            $loggedPlayer = $this->getUser()->getPlayer();
            $playerList = new PlayerList();
            $playerList->setPlayer($loggedPlayer);
            $em->persist($playerList);
        } else {
            $loggedPlayer = $this->getUser()->getPlayer();
            $playerList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findByPlayer($loggedPlayer);
            $em->remove($playerList[0]);
        }
        $em->flush();
        return $this->redirect('/');
    }
    
    /**
     * @Route("/showPlayerList", name="showPlayerList")
     */
    public function showPlayerListAction()
    {
        $playersList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findAll();
//        dump($playersList[0]->getPlayer()->getId());die;
        $playersOnList = [];
        $playerRepository = $this->getDoctrine()->getRepository('BasketballBundle:Player');
        
        if (!empty($playersList)) {
            foreach ($playersList as $key => $value) {
                $player = $playerRepository->findById($value->getPlayer()->getId());
                $playersOnList[] = $player[0];
            }
        } else {
            return $this->render('BasketballBundle:Player:show_players_list.html.twig', array());
        }
        return $this->render('BasketballBundle:Player:show_players_list.html.twig', array(
            'players' => $playersOnList
         ));
    }
    
    /**
     * @Route("/showGameHistoryList")
     */
    public function showGameHistoryList()
    {
        $em = $this->getDoctrine()->getManager();
        $gamesHistory = $em->getRepository('BasketballBundle:GameResult')->findAll();
//        dump($gamesHistory);die;
        
        return $this->render('BasketballBundle:Player:showGameHistoryList.html.twig', array(
            'games' => $gamesHistory
        ));
    }
    
    /**
     * @Route("/showGameDetails/{gameId}", name="showGameDetails") 
     */
    public function showGameDetailsAction($gameId)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('BasketballBundle:GameResult')->findOneById($gameId);
        
        return $this->render('BasketballBundle:Player:showGameDetails.html.twig', array(
            'game' => $game,
        ));
    }
    
    
    /**
     * @Route("/userPanel", name="userPanel")
     */
    public function userPanelAction() 
    {   
        if ($this->getUser()->getPlayer() != null) {
            $player = 1;
        } else {
            $player = 0;
        }
        
        $playersList = $this->getDoctrine()->getRepository('BasketballBundle:PlayerList')->findAll();
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
        
        return $this->render('BasketballBundle:Player:user_panel.html.twig', array(
            'player' => $player,
            'playerCheckedIn' => $playerCheckedIn
        ));
    }

}
