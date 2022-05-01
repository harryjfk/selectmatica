<?php

namespace Store\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FacturasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          /* ->add('idcliente',null,array('label' => false,'attr'=>array('style'=>'display:none;')))*/
            ->add('serie',null,array('label' => false))
            ->add('ano','number',array('label' => false))
            ->add('numero','number',array('label' => false))
            ->add('importe','text',array('label' => false))
            ->add('file','file',array('label' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\StoreBundle\Entity\Facturas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_storebundle_facturas';
    }
}
