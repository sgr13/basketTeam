<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Calendar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BasketballBundle\Entity\NextGame;


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
        $nextGame = new NextGame();
        $nextGame->setDate($date);
        $nextGame->setPlace($place);
        var_dump($nextGame);die();
        $em->persist($nextGame);
        $em->flush();
        
        die('Zrobione');
    }

}
