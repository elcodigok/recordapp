<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use QQi\RecordappBundle\Entity\Enlace;
use QQi\RecordappBundle\Entity\Usuario;

class EnlaceController extends Controller
{
	public function nuevoAction()
	{
		$peticion = $this->get('request');
		$em = $this->get('doctrine')->getEntityManager();

		$user = $this->get('security.context')->getToken()->getUser();
		$usuarioId = $user->getId();
		$usuario = $em->find('QQiRecordappBundle:Usuario', $usuarioId);

		$enlace = new Enlace();
		$enlace->setFecha(new \DateTime('now'));
		$enlace->setUsuario($usuario);
		$enlace->setEstado(True);

		if ($peticion->getMethod() == 'POST')
		{
			#$postData = $peticion->request->get('formTarea');
			$enlace->setTitulo($this->get('request')->request->get('titulo'));
			$enlace->setUrl($this->get('request')->request->get('url'));
			$em->persist($enlace);
			$em->flush();

			return $this->redirect($this->generateUrl('portada'));
		}

	}
}