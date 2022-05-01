<?php

namespace Common\SeguridadBundle\Form;

use Common\SeguridadBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Doctrine\ORM\EntityRepository;

class UsuarioType extends AbstractType {

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

        $builder->add('file','file', array('label' => false, 'translation_domain' => 'seguridad','required'=>false,'attr'=>array('class'=>'form-control')))
                ->add('nombre', 'text', array('label' => 'nombre', 'translation_domain' => 'seguridad','attr'=>array('class'=>'form-control')))
                ->add('primerApellido', 'text', array('label' => 'primer_apellido', 'translation_domain' => 'seguridad','attr'=>array('class'=>'form-control')))
                ->add('segundoApellido', 'text', array('label' => 'segundo_apellido', 'translation_domain' => 'seguridad','attr'=>array('class'=>'form-control')))
                ->add('username', 'text', array('label' => 'usuario', 'translation_domain' => 'seguridad','attr'=>array('class'=>'form-control')))
                ->add('email', 'email', array('label' => 'email', 'translation_domain' => 'seguridad','attr'=>array('class'=>'form-control')))
                ->add('password', 'repeated', array('translation_domain' => 'seguridad', 'required' => false,
                    'type' => 'password',
                    'invalid_message' => 'contresenyas_no_coinciden',
                    'first_options' => array('label' => 'contrasenya'),
                    'second_options' => array('label' => 'rep_contrasenya'),
                    
                ))   ->add('idcliente','text',array('attr'=>array('style'=>'background-color: #fff;
    border: 1px solid #aaa;height: 28px;
    border-radius: 4px;','class'=>'form-control'),'label' => 'ID', 'translation_domain' => 'messages'));
              /*  ->add('idcargo', 'entity', array('label' => 'cargo', 'translation_domain' => 'seguridad',
                    'class' => 'BandecBundle:Nomencladores',
                    'empty_value' => '---',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')->where("c.tipo = 'cargo' and c.activo = 1")->orderBy('c.nombre');
                    },
                    'required' => false
                ))*/;

      //  if(in_array('ROLE_GRUPO_USUARIO_NEW', $this->userEdit->getRoles())) {
            $builder->add('grupoid', 'entity', array('label' => 'grupo_usuario', 'translation_domain' => 'seguridad',
                'class' => 'CommonSeguridadBundle:SeguridadGrupo',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')->orderBy('g.nombreGrupo', 'asc');
                },
                'required' => false,'attr'=>array('class'=>'form-control')
            )) ->add('idcomercial', 'number', array('attr'=>array('class'=>'form-control'),'label' => 'comercial', 'translation_domain' => 'messages'))
              /*  ->add('company','text', array('label' => 'company', 'translation_domain' => 'seguridad','required'=>false,'attr'=>array('class'=>'form-control')))
            /*->add('idcomercial', 'entity', array('label' => 'grupo_usuario', 'translation_domain' => 'seguridad',
                'class' => 'CommonSeguridadBundle:Usuario',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')/*->orderBy('g.nombreGrupo', 'asc')*/;
               /* },
                'required' => false
            ))*/;/* ->add('idlocalidad', 'entity', array('label' => 'seleccione_localidad', 'translation_domain' => 'backend',
          'class' => 'BandecBundle:Zonasgeograficas',
          'query_builder' => function(EntityRepository $er) {
          return $er->createQueryBuilder('z')->where("z.tipoNivel='localidad'")->orderBy('z.nombre', 'asc');

          }
          )) */
            ;
       // }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
           /* 'csrf_protection'   => false,*/
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
