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
                $playerList = new PlayerList();
                $playerList->setPlayer($player[0]);
                $em->persist($playerList);
                $em->flush();
                
                return $this->redirect('/showList');
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
}
