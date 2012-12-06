<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use QQi\RecordappBundle\Entity\Tarea;
use QQi\RecordappBundle\Entity\Usuario;

class TareaController extends Controller
{
	public function nuevaAction()
	{
		$peticion = $this->get('request');
		$em = $this->get('doctrine')->getEntityManager();

		$user = $this->get('security.context')->getToken()->getUser();
		$usuarioId = $user->getId();
		$usuario = $em->find('QQiRecordappBundle:Usuario', $usuarioId);

		$tarea = new Tarea();
		$tarea->setFecha(new \DateTime('now'));
		$tarea->setUsuario($usuario);
		$tarea->setEstado(True);

		if ($peticion->getMethod() == 'POST')
		{
			#$postData = $peticion->request->get('formTarea');
			$tarea->setTitulo($this->get('request')->request->get('titulo'));
			$tarea->setNombre($this->get('request')->request->get('nombre'));
			$em->persist($tarea);
			$em->flush();

			return $this->redirect($this->generateUrl('portada'));
		}
	}

	public function eliminarAction($id)
	{
		$peticion = $this->get('request');
		$em = $this->getDoctrine()->getEntityManager();

		if (null == $tarea = $em->find('QQiRecordappBundle:Tarea', $id)) 
		{
        	return $this->render('QQiRecordappBundle:Default:error.html.twig');
		}

        $tarea->setEstado(False);
        $em->persist($tarea);
        $em->flush();
        return $this->redirect($this->generateUrl('portada'));
	}
}