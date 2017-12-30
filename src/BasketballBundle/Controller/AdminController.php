<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Calendar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BasketballBundle\Entity\NextGame;
use BasketballBundle\Entity\PlayersList;
use BasketballBundle\Entity\PlayerList;
use BasketballBundle\Entity\Team;
use BasketballBundle\Entity\GameResult;
use BasketballBundle\Entity\PlayersTeam;


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
    public function addGameResult(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($playerActive = $request->request->get('player')) {
            $playerRepository = $em->getRepository('BasketballBundle:Player');
            
            $playersArray=[];
            
            foreach ($playerActive as $value) {
                $playersArray[] = $playerRepository->findById($value);
            }
            var_dump($playersArray);
            die('ok');
        }
        
        $players = $em->getRepository('BasketballBundle:PlayerList')->findAll();
        $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
        
        if($request->request->get('firstTeam') && $request->request->get('secondTeam') && $request->request->get('firstTeamScore') && $request->request->get('secondTeamScore')) {
            
            $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
            $firstTeamAjax = $request->request->get('firstTeam');
            $secondTeamAjax = $request->request->get('secondTeam');
            $playerRepository = $em->getRepository('BasketballBundle:Player');
            $score = $request->request->get('firstTeamScore') . " : " . $request->request->get('secondTeamScore');
            $firstTeam = new PlayersTeam();
            $secondTeam = new PlayersTeam();
            $firstTeamNames = [];
            
            for($i = 0; $i != count($firstTeamAjax); $i++) {
                $player = $playerRepository->findById($firstTeamAjax[$i]);
                if ($i == 0 ) {
                    $firstTeam->setFirstPlayer($player[0]);
                    $firstTeamNames[] = $player[0]->getName();
                } else if ($i == 1) {
                    $firstTeam->setSecondPlayer($player[0]);
                    $firstTeamNames[] = $player[0]->getName();
                } else if ($i == 2) {
                    $firstTeam->setThirdPlayer($player[0]);
                    $firstTeamNames[] = $player[0]->getName();
                } else if ($i == 3) {
                    $firstTeam->setFourthPlayer($player[0]);
                    $firstTeamNames[] = $player[0]->getName();
                } else if ($i == 4) {
                    $firstTeam->setFifthPlayer($player[0]);
                    $firstTeamNames[] = $player[0]->getName();
                }
            }
            
            $secondTeamNames = [];
            
            for($i = 0; $i != count($secondTeamAjax); $i++) {
                $player = $playerRepository->findById($secondTeamAjax[$i]);
                if ($i == 0 ) {
                    $secondTeam->setFirstPlayer($player[0]);
                    $secondTeamNames[] = $player[0]->getName();
                } else if ($i == 1) {
                    $secondTeam->setSecondPlayer($player[0]);
                    $secondTeamNames[] = $player[0]->getName();
                } else if ($i == 2) {
                    $secondTeam->setThirdPlayer($player[0]);
                    $secondTeamNames[] = $player[0]->getName();
                } else if ($i == 3) {
                    $secondTeam->setFourthPlayer($player[0]);
                    $secondTeamNames[] = $player[0]->getName();
                } else {
                    $secondTeam->setFifthPlayer($player[0]);
                    $secondTeamNames[] = $player[0]->getName();
                }
            }

//            
            $em->persist($firstTeam);
            $em->flush();
            $em->persist($secondTeam);
            $em->flush();
            
            $gameResult = new GameResult();
            $gameResult->setScore($score);
            $gameResult->setTeam1($firstTeam);
            $gameResult->setTeam2($secondTeam);
            $gameResult->setDate($nextGame[0]->getDate());
            
            $em->persist($gameResult);
            $em->flush();
            
            $gameData = [
                'date' => $gameResult->getDate(),
                'score' => $score,
                'firstTeam' => $firstTeamNames,
                'secondTeam' => $secondTeamNames
            ];
            
            return new JsonResponse($gameData);
            
        }
        
        
        return $this->render('BasketballBundle:Admin:add_game_result.html.twig', array(
            'nextGame' => $nextGame[0],
            'players' => $players
        ));
    }
    
    /**
     * @Route("/saveNewGame/{date}/{place}", name="saveNewGame")
     */
    public function saveNewGameAction(Request $request, $date, $place)
    {   
        $em = $this->getDoctrine()->getManager();
        $lastGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
        
        if (!empty($lastGame)) {
            $em->remove($lastGame[0]);
            $em->flush();
        }
        
        $oldPlayersList = $em->getRepository('BasketballBundle:PlayerList')->findAll();
//        var_dump($oldPlayersList);
        if (!empty($oldPlayersList)) {
//            $em->remove($oldPlayersList[0]);
//            $em->flush();
            $query = $em->createQuery('DELETE BasketballBundle:PlayerList');
            $query->execute();
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
     * @Route("/test")
     */
    public function test(Request $request)
    {
//        $firstTeam = new PlayersTeam();
//        $secondTeam = new Team();
        $em = $this->getDoctrine()->getManager();
//        
//        $playerRepository = $em->getRepository('BasketballBundle:Player');
//        $player1 = $playerRepository->findById(1);
//        $player2 = $playerRepository->findById(2);
//        $firstTeam->setFirstPlayer($player1[0]);
//        $firstTeam->setSecondPlayer($player2[0]);
//        $player2 = $playerRepository->findById(2);
//        $firstTeam->setPlayer($player2[0]);
//        $firstTeam->setPlayer($player[0]);
//        var_dump($firstTeam);die();
        
        
        $firstTeamAjax = [0=> '1', 1 => '1'];
            $secondTeamAjax = [0=> '2', 1 => '2'];
            $playerRepository = $em->getRepository('BasketballBundle:Player');
            $firstTeam = new PlayersTeam();
            $secondTeam = new PlayersTeam();
            for($i = 0; $i != count($firstTeamAjax); $i++) {
                $player = $playerRepository->findById($firstTeamAjax[$i]);
                if ($i == 0 ) {
                    $firstTeam->setFirstPlayer($player[0]);
                } else if ($i == 1) {
                    $firstTeam->setSecondPlayer($player[0]);
                } else if ($i == 2) {
                    $firstTeam->setThirdPlayer($player[0]);
                } else if ($i == 3) {
                    $firstTeam->setFourthPlayer($player[0]);
                } else if ($i == 4) {
                    $firstTeam->setFifthPlayer($player[0]);
                }
            }
            
            
            for($i = 0; $i != count($secondTeamAjax); $i++) {
                $player = $playerRepository->findById($secondTeamAjax[$i]);
                if ($i == 0 ) {
                    $secondTeam->setFirstPlayer($player[0]);
                } else if ($i == 1) {
                    $secondTeam->setSecondPlayer($player[0]);
                } else if ($i == 2) {
                    $secondTeam->setThirdPlayer($player[0]);
                } else if ($i == 3) {
                    $secondTeam->setFourthPlayer($player[0]);
                } else {
                    $secondTeam->setFifthPlayer($player[0]);
                }
            }
            $score = '55 : 66';
        
        $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
        
        $gameResult = new GameResult();
        $gameResult->setScore($score);
        $gameResult->setTeam1($firstTeam);
        $gameResult->setTeam2($secondTeam);
        $gameResult->setDate($nextGame[0]->getDate());
        
                    $em->persist($gameResult);
            $em->flush();
        
        var_dump($gameResult);die();
    }
        
    /**
     * @Route("/gameDetails/{id}", name="gameDetails")
     */
    public function gameDetailsAction($id, Request $request)
    {   
//        $path = $request->server->get('DOCUMENT_ROOT').$request->getBasePath();
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('BasketballBundle:GameResult')->findOneById($id);
        
        return $this->render('BasketballBundle:Admin:game_details.html.twig', array(
            'game' => $game,
        ));
        
    }
    
    /**
     * @Route("/card", name="card")
     */
    public function cardAction()
    {
        return $this->render('BasketballBundle:Admin:card.html.twig', array(
        ));
    }
    
    /**
     * @Route("/selectGameType/{year}/{month}/{day}/{noDay}", name="selectGameType")
     */
    public function selectGameTypeAction(Request $request, $year, $month, $day, $noDay)
    {
        var_dump('Działa'); die;
    }
}   
