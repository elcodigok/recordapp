<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use QQi\RecordappBundle\Entity\Rol;
use QQi\RecordappBundle\Form\RolType;

class RolController extends Controller
{
	public function listadoAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
        $listadoRol = $em->getRepository('QQiRecordappBundle:Rol')->findAll();

        return $this->render('QQiRecordappBundle:Rol:listado.html.twig', array(
        	'listado' => $listadoRol,
        	));
	}
    
    public function nuevoAction()
    {
		$peticion = $this->get('request');
		$em = $this->get('doctrine')->getEntityManager();

		$rol = new Rol();
		
		$formulario = $this->get('form.factory')->create(new RolType());
		$formulario->setData($rol);

		if ($peticion->getMethod() == 'POST') {
			$formulario->bindRequest($peticion);

			if ($formulario->isValid()) {
				$em->persist($rol);
				$em->flush();
				$peticion->getSession()->setFlash('notice', 'Se ha creado correctamente el alumno');

				return $this->redirect($this->generateUrl('admin_rol_listado'));
			}
		}
		return $this->render('QQiRecordappBundle:Rol:nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
	}
} 
