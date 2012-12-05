<?php

namespace QQi\RecordappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('label' => 'Nombre:'))
            ->add('apellido', 'text', array('label' => 'Apellido:'))
            //->add('email', 'email', array('label' => 'Correo electrónico:'))
            //->add('password', 'password', array('label' => 'Contraseña'))
            ->add('activo')
            ->add('usuario_rol')
            ->add('grupo')
        ;
    }

    public function getName()
    {
        return 'usuarioedittype';
    }
}
