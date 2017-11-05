<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\Player;
use BasketballBundle\Form\PlayerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends Controller
{
    /**
     * @Route("/addPlayer", name="addPlayer")
     */
    public function addPlayerAction(Request $request)
    {   
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();
            $player->setGames(12);
            $user = $this->getUser();
            $player->setUser($user->getId());
            
            $photoFront = $player->getPhotoFront();
            $photoBack = $player->getPhotoBack();
            $pathToImg = $request->server->get('DOCUMENT_ROOT').$request->getBasePath() . '/photos';
            
             $photoFrontName = md5(uniqid()) . '.' . $photoFront->guessExtension();
             $photoBackName = md5(uniqid()) . '.' . $photoBack->guessExtension();
             
            $photoFront->move(
                $pathToImg,
                $photoFrontName
            );
             
            $photoBack->move(
                $pathToImg,
                $photoBackName
            );
            
            $player->setPhotoFront($photoFrontName);
            $player->setPhotoBack($photoBackName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            
            return new Response('<h1>Działa!!!</h1>');
             
        }
        
        return $this->render('BasketballBundle:Player:add_player.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/editPlayer")
     */
    public function editPlayerAction()
    {
        return $this->render('BasketballBundle:Player:edit_player.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deletePlayer")
     */
    public function deletePlayerAction()
    {
        return $this->render('BasketballBundle:Player:delete_player.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/checkIn")
     */
    public function checkInAction()
    {
        return $this->render('BasketballBundle:Player:check_in.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/checkOut")
     */
    public function checkOutAction()
    {
        return $this->render('BasketballBundle:Player:check_out.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/userPanel", name="userPanel")
     */
    public function userPanelAction() 
    {
        return $this->render('BasketballBundle:Player:user_panel.html.twig', array(
            // ...
        ));
    }

}
