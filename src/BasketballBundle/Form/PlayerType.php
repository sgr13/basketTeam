<?php

namespace BasketballBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use BasketballBundle\Entity\Player;

class PlayerType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        
        $builder
                ->add('name', TextType::class, array('label' => 'Imię:'))
                ->add('nickname', TextType::class, array('label' => 'Nickname:'))
                ->add('height', IntegerType::class, ['label' => 'Wzrost: '])
                ->add('specialisation', EntityType::class, array(
                'class' => 'BasketballBundle:Specialisation',
                'choice_label' => 'name', 'label' => 'Mocna strona:'))
                ->add('photoFront', FileType::class, array('label' => 'Zdjęcie 1'))
                ->add('photoBack', FileType::class, array('label' => 'Zdjecie2:'))
                ->add('submit', SubmitType::class, ["label" => 'Dodaj']);               
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Player::class
        ]);
    }
}