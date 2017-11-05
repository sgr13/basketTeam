<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialisation
 *
 * @ORM\Table(name="specialisation")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\SpecialisationRepository")
 */
class Specialisation
{   
    
    /**
     * @ORM\OneToMany(targetEntity="Player", mappedBy="specialisation")
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     *
     * @return Specialisation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    function getPlayer() {
        return $this->player;
    }

    function setPlayer($player) {
        $this->player = $player;
    }

}

