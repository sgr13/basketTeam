<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BasketballBundle\Entity\NextGame;
use BasketballBundle\Entity\PlayersList;
use BasketballBundle\Entity\PlayerList;
use BasketballBundle\Entity\Player;
use BasketballBundle\Form\PlayerType;

class AdminController extends Controller
{    
    /**
     * @Route("/adminPanel", name="adminPanel")
     */
    public function adminPanelAction()
    {
        return $this->render('BasketballBundle:Admin:admin_panel.html.twig', array(
        ));
    }
    
    /**
     * @Route("/addNextGame", name="addNextGame")
     */
    public function addNextGameAction(Request $request)
    {   
        $calendarRepository = $this->getDoctrine()->getRepository('BasketballBundle:Calendar');
        $calendar = $calendarRepository->getPresentDayCalendar();
        
        if($request->request->get('selectedMonth') && $request->request->get('selectedYear')){
        
            $selectedMonth = $request->request->get('selectedMonth');
            $selectedYear = $request->request->get('selectedYear');
            $calendar = $calendarRepository->getChosenDayCalendar($selectedMonth, $selectedYear);

            return new JsonResponse($calendar);
        }

        return $this->render('BasketballBundle:Admin:add_next_game.html.twig', $calendar
        );
    }
    
    /**
      * @Route("/saveNewGame/{date}/{place}", name="saveNewGame")
      */
     public function saveNewGameAction($date, $place)
     {
         $em = $this->getDoctrine()->getManager();
         $lastGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
         if (!empty($lastGame)) {
             $em->remove($lastGame[0]);
             $em->flush();
         }
         $newPlayersList = new PlayersList();
         $em->persist($newPlayersList);
         $em->flush();
         
         $nextGame = new NextGame();
         $nextGame->setDate($date);
         $nextGame->setPlace($place);
         $nextGame->setPlayersList($newPlayersList);
         
         $em->persist($nextGame);
         $em->flush();
         return $this->redirect('/adminPanel');
     }
    
    /**
     * @Route("/gameIndex", name="gameIndex")
     */
    public function gameIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gamesHistory = $em->getRepository('BasketballBundle:GameResult')->findAll();
        
        return $this->render('BasketballBundle:Admin:game_index.html.twig', array(
            'games' => $gamesHistory
        ));
        
    }
    
    /**
     * @Route("/addGameResult", name="addGameResult")
     */
    public function addGameResultAction()
    {
        $em = $this->getDoctrine()->getManager();
                
        $players = $em->getRepository('BasketballBundle:PlayerList')->findAll();
        if (empty($players)) {
            return $this->render('BasketballBundle:Admin:add_game_result.html.twig', array());
        }
        $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
               
        return $this->render('BasketballBundle:Admin:add_game_result.html.twig', array(
            'nextGame' => $nextGame[0],
            'players' => $players
        ));
    }
    
    /**
     * @Route("/addGameResultAjax", name="addGameResultAjax")
     */
    public function addGameResultAjaxAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        if ($request->request->get('selectedPlayers') && $result = $request->request->get('result')) {
            $selectedPlayers = $request->request->get('selectedPlayers');
            $gameDate = $request->request->get('date');
            $playersListRepository = $em->getRepository('BasketballBundle:PlayerList');
            $teamPlayersId = $playersListRepository->getTeamPlayersId($selectedPlayers);
            
            $score = $result[0] . ':' . $result[1];            
            $readyTeams = $playersListRepository->getReadyTeams($teamPlayersId);
            
            $oldPlayersList = $em->getRepository('BasketballBundle:PlayerList')->findAll();
            if (!empty($oldPlayersList)) {
                $query = $em->createQuery('DELETE BasketballBundle:PlayerList');
                $query->execute();
            }

            $em->persist($readyTeams[0]);
            $em->persist($readyTeams[1]);
            $readyResult = $em->getRepository('BasketballBundle:GameResult')->getReadyGameResult($score, $readyTeams[0], $readyTeams[1], $gameDate);
            $em->persist($readyResult);
            $em->flush();
            
            return new JsonResponse($readyTeams[1]->getFirstPlayer()->getName());
            
        }
    }
    
    /**
     * @Route("/gameDetails/{id}", name="gameDetails")
     */
    public function gameDetailsAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('BasketballBundle:GameResult')->findOneById($id);
        
        return $this->render('BasketballBundle:Admin:game_details.html.twig', array(
            'game' => $game,
        ));
        
    }
        
    /**
     * @Route("/showList", name="showList")
     */
    public function showListAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        
        if ($player = $request->request->get('player')) {
                $player = $em->getRepository('BasketballBundle:Player')->findByName($player);
                $playerList = new PlayerList();
                $playerList->setPlayer($player[0]);
                $em->persist($playerList);
                $em->flush();
       }
        
        $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
        $playersList = $em->getRepository('BasketballBundle:PlayerList')->findAll();
        $players = $em->getRepository('BasketballBundle:Player')->findAll();

        return $this->render('BasketballBundle:Admin:showList.html.twig', array(
            'nextGame' => $nextGame[0],
            'playersList' => $playersList,
            'players' => $players
        ));
    }
    
    /**
     * @Route("/deletePlayerFromList/{id}", name="deletePlayerFromList")
     */
    public function deletePlayerFromListAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('BasketballBundle:PlayerList')->findOneById($id);
        
        if ($player != null) {
            $em->remove($player);
            $em->flush();
        }

        return $this->redirect('/showList');        
    }
    
    /**
     * @Route("addPlayerToUser", name="addPlayerToUser")
     */
    public function addPlayerToUser(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('BasketballBundle:User')->findAll();
        
        return $this->render('BasketballBundle:Admin:addPlayerToUser.html.twig', array(
            'users' => $users,
        ));
    }
    
    /**
     * @Route("addPlayerToUserStepTwo/{userId}", name="addPlayerToUserStepTwo")
     */
    public function addPlayerToUserStepTwoAction (Request $request, $userId)
    {
//        dump($userId);die;
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();
            $player->setGames(12);
            $user = $this->getDoctrine()->getRepository('BasketballBundle:User')->find($userId);
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
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            
            return $this->redirect('/adminPanel');
             
        }
        
        return $this->render('BasketballBundle:Admin:addPlayerToUserAdmin.html.twig', array(
            'form' => $form->createView()
        ));
    }
}   
