<?php

namespace Store\RestBundle\Form;

use Store\StoreBundle\Form\FacturasType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Facturas', 'collection', array(
            'type'=>new FacturasType(),     'required' => true,
            'label'    => false,'allow_add'    => true,
        ));

     /*   $builder->add('iduser')
            ->add('Lines', 'collection', [
             /*   'type'     => 'form',*/
         /*       'required' => true,
                'label'    => false,
             //  'type'=>"\Store\StoreBundle\Form\CartlineType"
            ])
            ;*/
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\RestBundle\Entity\Clientes'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'store_restbundle_clientes';
    }
}
