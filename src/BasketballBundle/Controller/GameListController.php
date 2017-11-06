<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameListController extends Controller
{
    /**
     * @Route("/addGameList")
     */
    public function addGameListAction()
    {
        return $this->render('BasketballBundle:GameList:add_game_list.html.twig', array(
            
        ));
    }

    /**
     * @Route("/editGameList")
     */
    public function editGameListAction()
    {
        return $this->render('BasketballBundle:GameList:edit_game_list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteGameList")
     */
    public function deleteGameListAction()
    {
        return $this->render('BasketballBundle:GameList:delete_game_list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/loadGameList")
     */
    public function loadGameListAction()
    {
        return $this->render('BasketballBundle:GameList:load_game_list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/checkInGameList")
     */
    public function checkInGameListAction()
    {
        return $this->render('BasketballBundle:GameList:check_in_game_list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/checkOutGameList")
     */
    public function checkOutGameListAction()
    {
        return $this->render('BasketballBundle:GameList:check_out_game_list.html.twig', array(
            // ...
        ));
    }

}
