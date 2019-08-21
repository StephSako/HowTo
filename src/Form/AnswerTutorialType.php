<?php

namespace App\Form;

use App\Entity\AnswerTutorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerTutorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextType::class,[
            'required' => true,
            'data' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'Votre commentaire',
                'value' => null
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnswerTutorial::class
        ]);
    }
}
