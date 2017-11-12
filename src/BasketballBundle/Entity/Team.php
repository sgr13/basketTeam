<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\TeamRepository")
 */
class Team
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
