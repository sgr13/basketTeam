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
                ->add('photoFront', FileType::class, array('label' => 'Zdjecie 1:', 'data_class' => null))
                ->add('photoBack', FileType::class, array('label' => 'Zdjecie 2:', 'data_class' => null))
                ->add('submit', SubmitType::class, ["label" => 'Ok']);
        
        if ($options['noPhoto']) {
            $builder->remove('photoFront')
                    ->remove('photoBack');
        }
        
        if ($options['onlyPhoto']) {
            $builder->remove('name')
                    ->remove('nickname')
                    ->remove('height')
                    ->remove('specialisation')
                    ->remove('nickname');
        }
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Player::class,
            'noPhoto' => false,
            'onlyPhoto' => false
        ]);
    }
}