<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 4/28/16
 * Time: 1:33 PM
 */
namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
/**
 * @ORM\Entity
 * @ORM\Table(name="media")
 *
 */
class Media
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Media path
     *
     * @var string
     *
     * @ORM\Column(name="path", type="text", length=255, nullable=false)
     */
    protected $path;

    /**
     * @ORM\Column(name="imageName", type="string")
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     */
    private $imageName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

}