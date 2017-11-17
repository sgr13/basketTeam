<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayersTeam
 *
 * @ORM\Table(name="players_team")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\PlayersTeamRepository")
 */
class PlayersTeam
{   
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $firstPlayer;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    
    private $secondPlayer;
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    
    private $thirdPlayer;
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    
    private $fourthPlayer;
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $fifthPlayer;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    function getFirstPlayer() {
        return $this->firstPlayer;
    }

    function getSecondPlayer() {
        return $this->secondPlayer;
    }

    function getThirdPlayer() {
        return $this->thirdPlayer;
    }

    function getFourthPlayer() {
        return $this->fourthPlayer;
    }

    function getFifthPlayer() {
        return $this->fifthPlayer;
    }

    function setFirstPlayer($firstPlayer) {
        $this->firstPlayer = $firstPlayer;
    }

    function setSecondPlayer($secondPlayer) {
        $this->secondPlayer = $secondPlayer;
    }

    function setThirdPlayer($thirdPlayer) {
        $this->thirdPlayer = $thirdPlayer;
    }

    function setFourthPlayer($fourthPlayer) {
        $this->fourthPlayer = $fourthPlayer;
    }

    function setFifthPlayer($fifthPlayer) {
        $this->fifthPlayer = $fifthPlayer;
    }
}

