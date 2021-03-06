<?php

namespace BasketballBundle\Repository;

/**
 * PlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends \Doctrine\ORM\EntityRepository
{
    public function checkIfPlayerIsCheckedIn($user, $playersList)
    {
        if ($user->getPlayer() != null && count($playersList) > 0) {
            $loggedPlayerId = $user->getPlayer()->getId();
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
        return $playerCheckedIn;
    }
}
