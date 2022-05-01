<?php

namespace Common\SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Doctrine\ORM\EntityRepository,
    Doctrine\Common\Persistence\ObjectManager;

class SeguridadGrupoType extends AbstractType {

    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    private function getChoices() {
        $dql = "select sr, s from CommonSeguridadBundle:SeguridadSeccionesRoles as sr join sr.seccionid as s order by s.nombre asc";
        $result = $this->manager->createQuery($dql)->getResult();

        $choices = array();
        foreach ($result as $entity) {

            $choices[$entity->getSeccionid()->getNombre()][$entity->getNombre()] = $entity->getRol();
        }
        /* echo '<pre>';
          print_r($choices);
          echo '</pre>';
          exit; */
        return $choices;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('nombreGrupo', 'text', array('label' => 'nombre', 'translation_domain' => 'seguridad'))
                
                ->add('rol', 'entity', array('label' => 'roles', 'translation_domain' => 'seguridad', 'attr'=>array('class'=>'browser-default', 'style'=>'height:400px'),
                    'class' => 'CommonSeguridadBundle:SeguridadSeccionesRoles',
                    'query_builder' => function(EntityRepository $er) {
                                                
                        return $er->createQueryBuilder('r')
                                ->select('r') 
                                ->innerJoin('CommonSeguridadBundle:SeguridadSecciones', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.seccionid = s.id');
                        
                    },
                    'multiple' => true,                    
                    'group_by' => function($rol, $key, $index) {
                      return $rol->getSeccionid();
                    }
                ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Common\SeguridadBundle\Entity\SeguridadGrupo'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bandec_seguridadbundle_seguridadgrupo';
    }

}
