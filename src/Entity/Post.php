<?php

namespace App\Entity;


use symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */

class Post {
   /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private ?string $title = NULL;

    /**
     * @ORM\Column(type="text", length=320)
     */
    private string $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $image = NULL;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function setId (int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
  
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
  
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }
  
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
  
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
