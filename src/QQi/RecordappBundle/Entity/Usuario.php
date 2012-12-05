<?php

namespace QQi\RecordappBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Table(name="usuario")
* @ORM\Entity()
* @UniqueEntity(fields="email")
*/
class Usuario implements UserInterface, \Serializable, AdvancedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(20)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(20)
     */
    protected $apellido;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\MinLength(5)
     * @Assert\MaxLength(15)
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $activo;

    /**
     * @ORM\ManyToMany(targetEntity="Rol", cascade={"persist"})
     * @ORM\JoinTable(name="usuario_rol",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $usuario_rol;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="tarea")
     */
    protected $tareas;

    public function __construct()
    {
        $this->tareas = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->usuario_rol = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->activo = true;
    }

    public function addTareas(\QQi\RecordappBundle\Entity\Tarea $tarea)
    {
        $this->tareas[] = $tarea;
    }

    public function getTareas()
    {
        return $this->tareas;
    }

    public function addRole(\QQi\RecordappBundle\Entity\Rol $roles)
    {
    	$this->usuario_rol[] = $roles;
    }

    public function setUsuarioRol($roles)
    {
    	$this->usuario_rol = $roles;
    }

    public function getUsuarioRol()
    {
    	return $this->usuario_rol;
    }

    public function getRoles()
    {
    	return $this->usuario_rol->toArray();
        #return array('ROLE_USER');
    }

    public function __toString()
    {
    	return $this->email;
    }

    public function serialize()
    {
    	return serialize(array(
    		$this->getId()
    		));
    }

    public function unserialize($serialized)
    {
    	$arr = unserialize($serialized);
    	$this->id = ($arr[0]);
    }

    public function getId()
    {
    	return $this->id;
    }

    public function getNombre()
    {
    	return $this->nombre;
    }

    public function setNombre($nombre)
    {
    	$this->nombre = $nombre;
    }

    public function getApellido()
    {
    	return $this->apellido;
    }

    public function setApellido($apellido)
    {
    	$this->apellido = $apellido;
    }

    public function getEmail()
    {
    	return $this->email;
    }

    public function setEmail($email)
    {
    	$this->email = $email;
    }

    public function getPassword()
    {
    	return $this->password;
    }

    public function setPassword($password)
    {
    	$this->password = $password;
    }

    public function getSalt()
    {
    	return false;
    }

    public function getUsername()
    {
    	return $this->email;
    }

    public function eraseCredentials()
    {

    }

    public function equals(IserInterface $user)
    {
    	return $user->getUsername() == $this->getUsername();
    }

    public function getActivo()
    {
    	return $this->activo;
    }

    public function setActivo($activo)
    {
    	$this->activo = $activo;
    }

    public function isAccountNonExpired()
    {
    	return true;
    }

    public function isAccountNonLocked()
    {
    	return true;
    }

    public function isCredentialsNonExpired()
    {
    	return true;
    }

    public function isEnabled()
    {
    	return $this->activo;
    }

}