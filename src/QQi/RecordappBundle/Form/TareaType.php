<?php

namespace QQi\RecordappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TareaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', 'text', array('label' => 'Título:'))
            ->add('nombre', 'textarea', array('label' => 'Contenido:'))
            ->add('fecha', 'date', array(
                'label' => 'Fecha:',
                'format' => 'dd-MMMM-yyyy',
                ))
            ->add('estado')
            #->add('created_at')
            #->add('updated_at')
            #->add('usuario')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QQi\RecordappBundle\Entity\Tarea'
        ));
    }

    public function getName()
    {
        return 'tareatype';
    }
}
