<?php

namespace BasketballBundle\Repository;
use BasketballBundle\Entity\Calendar;
/**
 * CalendarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CalendarRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPresentDayCalendar()
    {
        $month = date('m');
        $year = date('Y');
        
        $result = $this->showCalendar($month, $year);
        $result['month'] = $month;
        $result['year'] = $year;
        
        return $result;
    }
    
    public function getChosenDayCalendar($month, $year)
    {
        $result = $this->showCalendar($month, $year);
        $date = strtotime(date("Y-m-d"));
        $day = date('d', $date);
        
        $result['month'] = $month;
        $result['year'] = $year;
        $result['day'] = $day;
        
        return $result;
    }
    
    public function showCalendar($month, $year)
    {   
        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        $firstDayInMonth = date('N', $firstDay);
        $daysInMonth = cal_days_in_month(0, $month, $year);
        $numberOfWeeksInMonth = $this->getNumberOfWeeks($daysInMonth, $firstDayInMonth);
        $array = array(
            'numberOfWeeksInMonth' => $numberOfWeeksInMonth,
            'firstDayInMonth' => $firstDayInMonth,
            'daysInMonth' => $daysInMonth,
        );
        
        return $array;
        
//        self::getNumberOfWeeks();
    }
    
    public function getNumberOfWeeks($daysInMonth, $firstDayInMonth)
    {
        if ($daysInMonth == 28 && $firstDayInMonth == 1) {
            $numberOfWeeksInMonth = 4;
        } else if (($daysInMonth == 31 && $firstDayInMonth > 5) || $daysInMonth == 30 && $firstDayInMonth > 6) {
            $numberOfWeeksInMonth = 6;
        } else {
            $numberOfWeeksInMonth = 5;
        }
        
        return $numberOfWeeksInMonth;
    }
}