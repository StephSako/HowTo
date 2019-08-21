<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contents', TextareaType::class,[
                'attr' => ['class' => 'materialize-textarea']
            ])
            ->add('idSurfer', EntityType::class, array(
                'class' => 'App\Entity\Surfer',
                'choice_label' => function (User $user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                'query_builder' => function (EntityRepository $sr) {
                    return $sr->createQueryBuilder('s')
                        ->orderBy('s.idSurfer', 'ASC');
                }
            ))
            ->add('title', TextType::class,[
                'attr' => ['class' => 'input-field']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
            'translation_domain' => 'forms'
        ]);
    }
}
