<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use QQi\RecordappBundle\Entity\Tarea;
use QQi\RecordappBundle\Entity\Usuario;
use QQi\RecordappBundle\Form\TareaType;

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

		/* Se controla que la tarea que se va a eliminar 
		   corresponda al usuario que la creo. */
		$user = $this->get('security.context')->getToken()->getUser();
		$usuarioId = $user->getId();

		$repositorio = $this->getDoctrine()->getRepository('QQiRecordappBundle:Tarea');
        $query = $repositorio->createQueryBuilder('t')
                ->where('t.usuario = :usuario')
                ->andWhere('t.id = :id')
                ->setParameter('usuario', $usuarioId)
                ->setParameter('id', $id)
                ->getQuery();

        $tarea = $query->getResult();

		if ($tarea == null)
		{
			return $this->render('QQiRecordappBundle:Default:error.html.twig');
		}

		$tarea = $em->find('QQiRecordappBundle:Tarea', $id);

        $tarea->setEstado(False);
        $em->persist($tarea);
        $em->flush();
        return $this->redirect($this->generateUrl('portada'));
	}

	public function editarAction($id)
	{
		$peticion = $this->get('request');
		$em = $this->getDoctrine()->getEntityManager();

		/* Se controla que la tarea que se va a eliminar 
		   corresponda al usuario que la creo. */
		$user = $this->get('security.context')->getToken()->getUser();
		$usuarioId = $user->getId();

		$repositorio = $this->getDoctrine()->getRepository('QQiRecordappBundle:Tarea');
        $query = $repositorio->createQueryBuilder('t')
                ->where('t.usuario = :usuario')
                ->andWhere('t.id = :id')
                ->setParameter('usuario', $usuarioId)
                ->setParameter('id', $id)
                ->getQuery();

        $tarea = $query->getResult();

		if ($tarea == null)
		{
			return $this->render('QQiRecordappBundle:Default:error.html.twig');
		}

		$tarea = $em->find('QQiRecordappBundle:Tarea', $id);

		$formulario = $this->get('form.factory')->create(new TareaType);
		$formulario->setData($tarea);

		if ($peticion->getMethod() == 'POST'){
			$formulario->bindRequest($peticion);
			if ($formulario->isValid()){
				$em->persist($tarea);
				$em->flush();
				return $this->redirect($this->generateUrl('portada'));
			}
		}

		return $this->render('QQiRecordappBundle:Tarea:editar.html.twig', array(
			'formulario' => $formulario->createView(),
			'tarea' => $tarea,
			));
	}
}