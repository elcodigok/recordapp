<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use QQi\RecordappBundle\Entity\Tarea;
use QQi\RecordappBundle\Entity\Usuario;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    public function acercadeAction()
    {
        return $this->render('QQiRecordappBundle:Default:acercade.html.twig');
    }

    public function contactoAction()
    {
        return $this->render('QQiRecordappBundle:Default:contacto.html.twig');
    }

    public function ayudaAction()
    {
        return $this->render('QQiRecordappBundle:Default:ayuda.html.twig');
    }

    public function portadaAction()
    {
        $em = $this->get('doctrine')->getEntityManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $usuarioId = $user->getId();

        /*$listadoTareas = $em->getRepository('QQiRecordappBundle:Tarea')->findBy(array(
            'usuario' => $usuarioId,
            ), array('fecha' => 'ASC'));*/

        $repositorio = $this->getDoctrine()->getRepository('QQiRecordappBundle:Tarea');
        $query = $repositorio->createQueryBuilder('t')
                ->where('t.usuario = :usuario')
                ->setParameter('usuario', $usuarioId)
                ->orderBy('t.fecha', 'DESC')
                ->getQuery();

        $listadoTareas = $query->getResult();

        $fecha = new \DateTime();
        return $this->render('QQiRecordappBundle:Default:portada.html.twig', array(
            'fecha' => $fecha,
            'tareas' => $listadoTareas,
        ));
    }
}
