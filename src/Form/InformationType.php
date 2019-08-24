<?php

namespace App\Form;

use App\Entity\Informations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextType::class,[
            'required' => true,
            'data' => false,
            'label' => 'Votre message',
            'attr' => ['class' => 'htl', 'data-length' => 240]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Informations::class,
        ]);
    }
}
