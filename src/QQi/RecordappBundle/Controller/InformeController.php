<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use QQi\RecordappBundle\Entity\Tarea;
use QQi\RecordappBundle\Entity\Usuario;

class InformeController extends Controller
{
	public function semanalAction()
	{
		$em = $this->get('doctrine')->getEntityManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $usuarioId = $user->getId();

        $repositorio = $this->getDoctrine()->getRepository('QQiRecordappBundle:Tarea');
        $query = $repositorio->createQueryBuilder('t')
                ->where('t.usuario = :usuario')
                ->andWhere('t.estado = 1')
                ->setParameter('usuario', $usuarioId)
                ->orderBy('t.fecha', 'DESC')
                ->getQuery();

        $listadoTareas = $query->getResult();

        foreach ($listadoTareas as $valor) {
        	$json[] = $valor->getFecha();
        }

        return $this->render('QQiRecordappBundle:Informe:semanal.html.twig', array(
        		'tareas' => $listadoTareas,
        		'datos' => $json,
        	));
	}
}