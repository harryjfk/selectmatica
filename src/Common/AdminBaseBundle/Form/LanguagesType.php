<?php

namespace Common\AdminBaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LanguagesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label' => false,'attr'=>array('class'=>'form-control')))
            ->add('locale',null,array('label' => false,'attr'=>array('class'=>'form-control')))
            ->add('enabled',null,array('label' => false,'attr'=>array('class'=>'form-control')))
            ->add('file','file',array('label' => false,'attr'=>array('class'=>'form-control'),'required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Common\AdminBaseBundle\Entity\Languages'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'common_adminbasebundle_languages';
    }
}
