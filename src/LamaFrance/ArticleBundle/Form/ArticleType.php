<?php

namespace LamaFrance\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('oem')
            ->add('codelama')
            ->add('capacite')
            ->add('equivalencelama')
            ->add('couleur')
            ->add('description')
            ->add('type')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LamaFrance\ArticleBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'lamafrance_articlebundle_article';
    }
}
