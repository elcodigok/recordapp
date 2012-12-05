<?php

namespace QQi\RecordappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        $fecha = new \DateTime();
        return $this->render('QQiRecordappBundle:Default:portada.html.twig', array(
            'fecha' => $fecha,
        ));
    }
}
