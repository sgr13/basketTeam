<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayersList
 *
 * @ORM\Table(name="players_list")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\PlayersListRepository")
 */
class PlayersList
{   
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player3;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player4;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player5;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player6;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player7;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player8;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player9;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player10;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player11;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player12;
    
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
    
    function getPlayer1() {
        return $this->player1;
    }

    function getPlayer2() {
        return $this->player2;
    }

    function getPlayer3() {
        return $this->player3;
    }

    function getPlayer4() {
        return $this->player4;
    }

    function getPlayer5() {
        return $this->player5;
    }

    function getPlayer6() {
        return $this->player6;
    }

    function getPlayer7() {
        return $this->player7;
    }

    function getPlayer8() {
        return $this->player8;
    }

    function getPlayer9() {
        return $this->player9;
    }

    function getPlayer10() {
        return $this->player10;
    }

    function getPlayer11() {
        return $this->player11;
    }

    function getPlayer12() {
        return $this->player12;
    }

    function setPlayer1($player1) {
        $this->player1 = $player1;
    }

    function setPlayer2($player2) {
        $this->player2 = $player2;
    }

    function setPlayer3($player3) {
        $this->player3 = $player3;
    }

    function setPlayer4($player4) {
        $this->player4 = $player4;
    }

    function setPlayer5($player5) {
        $this->player5 = $player5;
    }

    function setPlayer6($player6) {
        $this->player6 = $player6;
    }

    function setPlayer7($player7) {
        $this->player7 = $player7;
    }

    function setPlayer8($player8) {
        $this->player8 = $player8;
    }

    function setPlayer9($player9) {
        $this->player9 = $player9;
    }

    function setPlayer10($player10) {
        $this->player10 = $player10;
    }

    function setPlayer11($player11) {
        $this->player11 = $player11;
    }

    function setPlayer12($player12) {
        $this->player12 = $player12;
    }
}
