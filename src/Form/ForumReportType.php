<?php

namespace App\Form;

use App\Entity\ForumReporting;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idReportingLabel', EntityType::class, array(
                'class' => 'App\Entity\ReportingLabel',
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $rl) {
                    return $rl->createQueryBuilder('rl')
                        ->orderBy('rl.label', 'ASC');
                }
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ForumReporting::class,
            'translation_domain' => 'forms'
        ]);
    }
}
