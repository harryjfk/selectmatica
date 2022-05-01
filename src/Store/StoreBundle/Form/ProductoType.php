<?php

namespace Store\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('headimg',null,array('attr'=>array('style'=>'display:none'),'label'=>false))
           ->add('destacado','checkbox',array('label'=>false,'attr'=>array('style'=>'display:none')))
           ->add('theadimg','text',array('attr'=>array('style'=>'display:none'),'label'=>false))
       /*
            ->add('Precios', 'collection', array(
                'type'=>new ProductPrecioType(),     'required' => true,
                'label'    => false, 'allow_add'    => true,'by_reference'=>false,'allow_delete' => true,
            ))
      */  ;
        /*   ->add('idproducto',null,array('translation_domain' => 'messages','label'=> 'product.name' ,  'attr'=>array('class'=>'form-control disabled')))
           ->add('idcategory','hidden',array('translation_domain' => 'messages',/*'class'=>'Store\StoreBundle\Entity\Category','label'=> 'category.name' ,  'attr'=>array('class'=>'form-control')))
        ;*/
}
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\StoreBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_storebundle_producto';
    }
}
