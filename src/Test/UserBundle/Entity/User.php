<?php

namespace Test\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Test\UserBundle\Entity\Contact", cascade={"remove"})
     * @ORM\JoinTable(name="Contact_User",joinColumns={@ORM\JoinColumn(name="User_Id", referencedColumnName="id", onDelete="CASCADE")},
     *                                  inverseJoinColumns={@ORM\JoinColumn(name="Contact_Id", referencedColumnName="idContact", onDelete="CASCADE")}
     *                                  )
     */
    private $contacts;

    public function __construct() {
        parent::__construct();
    }

    // your own logic

    public function getContact() {
        return $this->contacts;
    }

}
