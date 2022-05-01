<?php

namespace Store\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CartType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Lines', 'collection', array(
            'type'=>new CartlineType(),     'required' => true,
            'label'    => false,
        ))->add('observaciones','textarea',array('translation_domain' => 'messages','required' => false,'label'=> 'cart.observations','attr'=>array('class'=>'form-control') ))
            ->add('nocliente','text',array('translation_domain' => 'messages','required' => false,'label'=> 'cart.nocliente','attr'=>array('class'=>'form-control') ));

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
            'data_class' => 'Store\StoreBundle\Entity\Cart'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'store_storebundle_cart';
    }
}
