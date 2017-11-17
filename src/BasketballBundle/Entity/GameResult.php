<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameResult
 *
 * @ORM\Table(name="game_result")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\GameResultRepository")
 */
class GameResult
{   
    /**
     * @ORM\ManyToOne(targetEntity="PlayersTeam")
     */
    private $team1;
    
    /**
     * @ORM\ManyToOne(targetEntity="PlayersTeam")
     */
    private $team2;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="score", type="string", length=255)
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return GameResult
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return GameResult
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }
    
    function getTeam1() {
        return $this->team1;
    }

    function getTeam2() {
        return $this->team2;
    }

    function setTeam1($team1) {
        $this->team1 = $team1;
    }

    function setTeam2($team2) {
        $this->team2 = $team2;
    }
}

