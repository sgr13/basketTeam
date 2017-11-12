<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Calendar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BasketballBundle\Entity\NextGame;
use BasketballBundle\Entity\PlayersList;


class AdminController extends Controller
{
    /**
     * @Route("/selectDay", name="selectDay")
     */
    public function SelectDayAction(Request $request)
    {   
        $calendar = new Calendar();
        
        $month = date('m');
        $year = date('Y');
        
        $calendar->setMonth($month);
        $calendar->setYear($year);
        $calendar->showCalendar();
//        var_dump($calendar);

        if($request->request->get('selectedMonth') && $request->request->get('selectedYear')){
        
        $selectedMonth = $request->request->get('selectedMonth');
        $selectedYear = $request->request->get('selectedYear');
        $calendar->setMonth($selectedMonth);
        $calendar->setYear($selectedYear);
        $calendar->showCalendar();
        
        $calendar = [
            'day' => $calendar->getDay(),
            'month' => $calendar->getMonth(),
            'year' => $calendar->getYear(),
            'firstDayInMonth' => $calendar->getFirstDayInMonth(),
            'daysInMonth' => $calendar->getDaysInMonth(),
            'numberOfWeeksInMonth' => $calendar->getNumberOfWeeksInMonth()
        ];
            
        return new JsonResponse($calendar);
    }
        
        return $this->render('BasketballBundle:Admin:select_day.html.twig', array(
            'calendar' => $calendar,
            'year' => $year,
            'month' => $month
        ));
    }
    
    /**
     * @Route("/selectGameType/{year}/{month}/{day}/{noDay}", name="selectGameType")
     */
    public function selectGameTypeAction(Request $request, $year, $month, $day, $noDay)
    {
        var_dump('Działa'); die;
    }
    
    /**
     * @Route("/addNextGame", name="addNextGame")
     */
    public function addNextGameAction(Request $request)
    {   
        $calendar = new Calendar();
        
        $month = date('m');
        $year = date('Y');
        $today = date('d');
        
        $calendar->setMonth($month);
        $calendar->setYear($year);
        $calendar->showCalendar();
//        var_dump($calendar);

        if($request->request->get('selectedMonth') && $request->request->get('selectedYear')){
        
        $selectedMonth = $request->request->get('selectedMonth');
        $selectedYear = $request->request->get('selectedYear');
        $calendar->setMonth($selectedMonth);
        $calendar->setYear($selectedYear);
        $calendar->showCalendar();
        
        $calendar = [
            'day' => $calendar->getDay(),
            'month' => $calendar->getMonth(),
            'year' => $calendar->getYear(),
            'firstDayInMonth' => $calendar->getFirstDayInMonth(),
            'daysInMonth' => $calendar->getDaysInMonth(),
            'numberOfWeeksInMonth' => $calendar->getNumberOfWeeksInMonth()
        ];
            
        return new JsonResponse($calendar);
    }
    
        if ($request->request->get('place') && $request->request->get('selectedDate')) {
            var_dump('yeaaah');die();
        }

        return $this->render('BasketballBundle:Admin:add_next_game.html.twig', array(
            'calendar' => $calendar,
            'year' => $year,
            'month' => $month,
            'today' => $today
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
        
        $oldPlayersList = $em->getRepository('BasketballBundle:PlayersList')->findAll();
        
        if (!empty($oldPlayersList)) {
            $em->remove($oldPlayersList[0]);
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
        
        return $this->redirect('adminPanel');
    }
    
    /**
     * @Route("/adminPanel", name="adminPanel")
     */
    public function adminPanelAction()
    {
        return $this->render('BasketballBundle:Admin:admin_panel.html.twig', array(
        ));
    }
    
    /**
     * @Route("/addPlayerToNextGame", name="addPlayerToNextGame")
     */
    public function addPlayerToNextGameAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        
        if ($player = $request->request->get('player')) {
            $player = $em->getRepository('BasketballBundle:Player')->findByName($player);
            $player = $player[0];
            $playersList = $em->getRepository('BasketballBundle:PlayersList')->findAll();
            var_dump($playersList[0]);
            if (empty($playersList)) {
                die('Nie ma zaplanowanego meczu. Prosze dodać najbliższy mecz!');
            }
            
            if ($playersList[0]->getPlayer1() == null) {
                $playersList[0]->setPlayer1($player);
            } else if ($playersList[0]->getPlayer2() == null) {
                $playersList[0]->setPlayer2($player);
            } else if ($playersList[0]->getPlayer3() == null) {
                $playersList[0]->setPlayer3($player);
            } else if ($playersList[0]->getPlayer4() == null) {
                $playersList[0]->setPlayer4($player);
            } else if ($playersList[0]->getPlayer5() == null) {
                $playersList[0]->setPlayer5($player);
            } else if ($playersList[0]->getPlayer6() == null) {
                $playersList[0]->setPlayer6($player);
            } else if ($playersList[0]->getPlayer7() == null) {
                $playersList[0]->setPlayer7($player);
            } else if ($playersList[0]->getPlayer8() == null) {
                $playersList[0]->setPlayer8($player);
            } else if ($playersList[0]->getPlayer9() == null) {
                $playersList[0]->setPlayer9($player);
            } else if ($playersList[0]->getPlayer10() == null) {
                $playersList[0]->setPlayer10($player);
            } else if ($playersList[0]->getPlayer11() == null) {
                $playersList[0]->setPlayer11($player);
            } else if ($playersList[0]->getPlayer12() == null) {
                $playersList[0]->setPlayer12($player);
            } else {
                die('Nie ma miejsca na liście. Spróbuj później. Zawsze moze ktoś wypaśc :)');
            }
            
            $em->persist($playersList[0]);
            $em->flush();
            return $this->redirect('adminPanel');
            
        }
        
        $players = $em->getRepository('BasketballBundle:Player')->findAll();
        
        return $this->render('BasketballBundle:Admin:add_player_to_game.html.twig', array(
            'players' => $players
        ));
    }
    
    /**
     * @Route("/showList", name="showList")
     */
    public function showListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nextGame = $em->getRepository('BasketballBundle:NextGame')->findAll();
        $playersList = $em->getRepository('BasketballBundle:PlayersList')->findAll();
        $actualPalyersList = [];
        
        $actualPalyersList[0] = $playersList[0]->getPlayer1();
        $actualPalyersList[1] = $playersList[0]->getPlayer2();
        $actualPalyersList[2] = $playersList[0]->getPlayer3();
        $actualPalyersList[3] = $playersList[0]->getPlayer4();
        $actualPalyersList[4] = $playersList[0]->getPlayer5();
        $actualPalyersList[5] = $playersList[0]->getPlayer6();
        $actualPalyersList[6] = $playersList[0]->getPlayer7();
        $actualPalyersList[7] = $playersList[0]->getPlayer8();
        $actualPalyersList[8] = $playersList[0]->getPlayer9();
        $actualPalyersList[9] = $playersList[0]->getPlayer10();
        $actualPalyersList[10] = $playersList[0]->getPlayer11();
        $actualPalyersList[11] = $playersList[0]->getPlayer12();

        for ($i = 0; $i !=11; $i++) {
            
            if ($actualPalyersList[$i] == null && $actualPalyersList[$i + 1] != null) {
                $actualPalyersList[$i] = $actualPalyersList[$i + 1];
                $actualPalyersList[$i + 1] = null;
            }
        }
        
        return $this->render('BasketballBundle:Admin:showList.html.twig', array(
            'nextGame' => $nextGame[0],
            'playersList' => $actualPalyersList
        ));
    }
    
    /**
     * @Route("/deletePlayerFromList/{id}", name="deletePlayerFromList")
     */
    public function deletePlayerFromListAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
    }
}
