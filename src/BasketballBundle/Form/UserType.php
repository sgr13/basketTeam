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
use BasketballBundle\Entity\User;

class UserType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        
        $builder
                ->add('username', TextType::class,['label' => ' Login:'])
                ->add('email', EmailType::class, ['label' => 'E-mail: '])
                ->add('password', RepeatedType::class, [
                    'first_options'  => array('label' => 'Hasło:'),
                    'second_options'  => array('label' => 'Powtórz:'),
                    'invalid_message' => 'Hasło musi być zgodne!',
                    'type' => PasswordType::class
                ])
                ->add('submit', SubmitType::class, ["label" => 'Zarejestruj']);               
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
    
}