<?php

namespace BasketballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="BasketballBundle\Repository\PlayerRepository")
 */
class Player
{   
    /**
     * @ORM\ManyToOne(targetEntity="Specialisation", inversedBy="player")
     */
    private $specialisation;
    
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
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255)
     */
    private $nickname;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="games", type="integer")
     */
    private $games;

    /**
     * @var string
     *
     * @ORM\Column(name="photoFront", type="string", length=255)
     */
    private $photoFront;

    /**
     * @var string
     *
     * @ORM\Column(name="photoBack", type="string", length=255)
     */
    private $photoBack;


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
     * @return Player
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

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Player
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Player
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set games
     *
     * @param integer $games
     *
     * @return Player
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get games
     *
     * @return int
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set photoFront
     *
     * @param string $photoFront
     *
     * @return Player
     */
    public function setPhotoFront($photoFront)
    {
        $this->photoFront = $photoFront;

        return $this;
    }

    /**
     * Get photoFront
     *
     * @return string
     */
    public function getPhotoFront()
    {
        return $this->photoFront;
    }

    /**
     * Set photoBack
     *
     * @param string $photoBack
     *
     * @return Player
     */
    public function setPhotoBack($photoBack)
    {
        $this->photoBack = $photoBack;

        return $this;
    }

    /**
     * Get photoBack
     *
     * @return string
     */
    public function getPhotoBack()
    {
        return $this->photoBack;
    }
    
    function getSpecialisation() {
        return $this->specialisation;
    }

    function setSpecialisation($specialisation) {
        $this->specialisation = $specialisation;
    }

}

