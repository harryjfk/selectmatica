<?php

namespace Store\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      /*  $builder
            ->add('name',null,array('translation_domain' => 'messages','label'=> 'category.name' ,  'attr'=>array('class'=>'form-control')))
            ->add('idparent',null,array('translation_domain' => 'messages','label'=> 'category.parent' ,  'attr'=>array('class'=>'form-control')))
        ;
*/    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\StoreBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_storebundle_category';
    }
}
