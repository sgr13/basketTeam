<?php

namespace BasketballBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BasketballBundle\Entity\User;
use BasketballBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @Route("/register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {   
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirect('login');
        }
        
        return $this->render('BasketballBundle:Register:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
