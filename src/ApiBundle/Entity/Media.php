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
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    protected $path;

    /**
     * @ORM\Column(name="image", type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\Image(mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"})
     */
    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

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

}