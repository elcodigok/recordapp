<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Form as SymfonyForm;

use Symfony\Component\Security\Core\User\User;
use QQi\RecordappBundle\Entity\Usuario;
use QQi\RecordappBundle\Entity\Rol;
use QQi\RecordappBundle\Form\UsuarioType;
use QQi\RecordappBundle\Form\UsuarioEditType;

class UsuarioController extends Controller
{
	public function nuevoAction()
	{
		$peticion = $this->get('request');
		$em = $this->get('doctrine')->getEntityManager();

		$rol = $em->getRepository('QQiRecordappBundle:Rol')->findBy(array('nombre' => 'ROLE_USER'));
		

		$usuario = new Usuario();
		$usuario->setActivo(True);
		$usuario->setUsuarioRol($rol);
		
		$formulario = $this->get('form.factory')->create(new UsuarioType());
		$formulario->setData($usuario);

 		if ($peticion->getMethod() == 'POST') {
 			$formulario->bindRequest($peticion);
 
 			if ($formulario->isValid()) {
				$factory = $this->container->get('security.encoder_factory');
				$codificador = $factory->getEncoder($usuario);
				$password = $codificador->encodePassword($usuario->getPassword(), $usuario->getSalt());
				$usuario->setPassword($password);
 				$em->persist($usuario);
 				$em->flush();
 				$peticion->getSession()->setFlash('notice', 'Se ha creado correctamente el usuario');
 
 				return $this->redirect($this->generateUrl('admin_usuario_listado'));
 			}
 		}
		return $this->render('QQiRecordappBundle:Usuario:nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
	}

	public function listadoAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
        $listadoUsuario = $em->getRepository('QQiRecordappBundle:Usuario')->findAll();

        return $this->render('QQiRecordappBundle:Usuario:listado.html.twig', array(
        	'listado' => $listadoUsuario,
        	));
	}

	public function verAction($id)
	{
		$usuario = $this->getDoctrine()
				->getRepository('QQiRecordappBundle:Usuario')
				->find($id);

		if ($usuario == null) {
			return $this->render('QQiRecordappBundle:Default:error.html.twig');
		}

        return $this->render('QQiRecordappBundle:Usuario:ver.html.twig', array(
            'usuario' => $usuario,
        ));
	}

	public function loginAction()
	{
		if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
		{
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('QQiRecordappBundle:Usuario:login.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        ));
	}

	public function editarAction($id)
    {
    	$peticion = $this->get('request');
    	$em = $this->getDoctrine()->getEntityManager();

    	if (null == $usuario = $em->find('QQiRecordappBundle:Usuario', $id)) {
 	    	return $this->render('QQiRecordappBundle:Default:error.html.twig');
 	    }

 	    $formulario = $this->get('form.factory')->create(new UsuarioEditType, $usuario);
 	    #$formulario->setData($usuario);

 	    if ($peticion->getMethod() == 'POST'){
 	    	$formulario->bindRequest($peticion);
 	    	$usuarioAux = $em->find('QQiRecordappBundle:Usuario', $id);
 	    	$usuarioAux->setNombre($formulario->get('nombre')->getData());
 	    	$usuarioAux->setApellido($formulario->get('apellido')->getData());
 	    	$usuarioAux->setActivo($formulario->get('activo')->getData());
 	    	$usuarioAux->setUsuarioRol($formulario->get('usuario_rol')->getData());
 	    	$usuarioAux->setGrupo($formulario->get('grupo')->getData());

 	    	/*if ($formulario->isValid()){*/
 	    		$em->persist($usuarioAux);
 	    		$em->flush();
 	    		return $this->redirect($this->generateUrl('admin_usuario_listado'));
 	    	/*}*/
 	    }

 	    return $this->render('QQiInternetBundle:Usuario:editar.html.twig', array(
 	    	'formulario' => $formulario->createView(),
 	    	'usuario' => $usuario,
 	    	));

    }

    public function activarAction($id)
    {
    	$peticion = $this->get('request');
    	$em = $this->getDoctrine()->getEntityManager();

    	if (null == $usuario = $em->find('QQiRecordappBundle:Usuario', $id)) {
 	    	return $this->render('QQiRecordappBundle:Default:error.html.twig');
 	    }

 	    $usuario->setActivo(True);
 	    $em->persist($usuario);
 	    $em->flush();
 	    return $this->redirect($this->generateUrl('admin_usuario_listado'));
    }

    public function desactivarAction($id)
    {
    	$peticion = $this->get('request');
    	$em = $this->getDoctrine()->getEntityManager();

    	if (null == $usuario = $em->find('QQiRecordappBundle:Usuario', $id)) {
 	    	return $this->render('QQiRecordappBundle:Default:error.html.twig');
 	    }

 	    $usuario->setActivo(False);
 	    $em->persist($usuario);
 	    $em->flush();
 	    return $this->redirect($this->generateUrl('admin_usuario_listado'));
    }
}