<?php

namespace QQi\RecordappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('label' => 'Nombre:'))
            ->add('apellido', 'text', array('label' => 'Apellido:'))
            ->add('email', 'email', array('label' => 'Correo electrónico:'))
            ->add('password', 'password', array('label' => 'Contraseña'))
            //->add('activo')
            //->add('usuario_rol')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QQi\RecordappBundle\Entity\Usuario'
        ));
    }

    public function getName()
    {
        return 'usuariotype';
    }
}
