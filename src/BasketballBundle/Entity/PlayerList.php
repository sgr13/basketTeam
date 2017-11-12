<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerList
 *
 * @ORM\Table(name="player_list")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\PlayerListRepository")
 */
class PlayerList
{   
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;
    
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
    
    function getPlayer() {
        return $this->player;
    }

    function setPlayer($player) {
        $this->player = $player;
    }
}

