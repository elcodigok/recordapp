<?php 

namespace QQi\RecordappBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use QQi\RecordappBundle\Entity\Usuario;
use QQi\RecordappBundle\Entity\Rol;

class LoadInicial implements FixtureInterface, ContainerAwareInterface
{
	protected $manager;
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{
		$this->manager = $manager;

		# Add Rol Administrador
		$rolAdmin = new Rol();
		$rolAdmin->setNombre('ROLE_ADMIN');
		$manager->persist($rolAdmin);

		# Add Rol Usuario
		$rolUser = new Rol();
		$rolUser->setNombre('ROLE_USER');
		$manager->persist($rolUser);

		# Add Usuario Administrador
		$usuario = new Usuario();
    	$usuario->setNombre('admin');
    	$usuario->setApellido('Admin');
    	$usuario->setEmail('admin@admin.com');
    	$usuario->setActivo(True);
    	$factory = $this->container->get('security.encoder_factory');
    	$codificador = $factory->getEncoder($usuario);
    	$password = $codificador->encodePassword('admin', $usuario->getSalt());
    	$usuario->setPassword($password);
    	$usuario->addRole($rolAdmin);
    	$manager->persist($usuario);

    	# Add Usuario Administrador
		$usuario = new Usuario();
    	$usuario->setNombre('usuario');
    	$usuario->setApellido('Usuario');
    	$usuario->setEmail('usuario@usuario.com');
    	$usuario->setActivo(True);
    	$factory = $this->container->get('security.encoder_factory');
    	$codificador = $factory->getEncoder($usuario);
    	$password = $codificador->encodePassword('usuario', $usuario->getSalt());
    	$usuario->setPassword($password);
    	$usuario->addRole($rolUser);
    	$manager->persist($usuario);

		$manager->flush();
	}
}