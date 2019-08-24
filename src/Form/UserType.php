<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class,[
                'attr' => ['class' => 'htl', 'data-length' => 30]]
            )
            ->add('firstname', TextType::class,[
                'attr' => ['class' => 'htl', 'data-length' => 30]])
            ->add('mail', EmailType::class)
            ->add('imageFile', FileType::class,[
                'required' => false
            ])
            ->add('password', PasswordType::class,[
                'attr' => ['class' => 'htl', 'data-length' => 30]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
