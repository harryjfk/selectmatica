<?php

namespace Common\SeguridadBundle\Form;

use Common\SeguridadBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Doctrine\ORM\EntityRepository;

class UsuarioSimpleType extends AbstractType {

    private $userEdit;

    public function __construct(Usuario $user)
    {
        $this->userEdit = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
->add('file','file', array('label' => false, 'translation_domain' => 'seguridad','required'=>false))
                ->add('password', 'repeated', array('translation_domain' => 'seguridad', 'required' => false,
                    'type' => 'password',
                    'invalid_message' => 'contresenyas_no_coinciden',
                    'first_options' => array('label' => 'contrasenya'),
                    'second_options' => array('label' => 'rep_contrasenya'),
                    
                ))
            ;
       // }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Common\SeguridadBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'usuario';
    }

}
