<?php

namespace FollowMeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_mail", columns={"user_mail"})}, indexes={@ORM\Index(name="user_level_id", columns={"user_level_id"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="user_mail", type="string", length=128, nullable=false)
     */
    private $userMail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pswd", type="string", length=128, nullable=false)
     */
    private $userPswd;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var \UserLevel
     *
     * @ORM\ManyToOne(targetEntity="\ASCII\Entity\UserLevel", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_level_id", referencedColumnName="user_level_id")
     * })
     */




    /**
     * Set userMail
     *
     * @param string $userMail
     *
     * @return User
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;

        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Set userPswd
     *
     * @param string $userPswd
     *
     * @return User
     */
    public function setUserPswd($userPswd)
    {
        $this->userPswd = $userPswd;

        return $this;
    }

    /**
     * Get userPswd
     *
     * @return string
     */
    public function getUserPswd()
    {
        return $this->userPswd;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }


}
