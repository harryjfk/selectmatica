<?php

namespace Store\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartlineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad', 'integer', [
                'scale'         => 0,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_FLOOR,
                'required'      => true,
                'label'         => false,
                'attr'          => ['min' =>1, 'class'=>'form-control' ]])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\StoreBundle\Entity\Cartline'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'store_storebundle_cartline';
    }
}
