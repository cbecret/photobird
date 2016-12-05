<?php

namespace PhotosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photo
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="PhotosBundle\Repository\PhotoRepository")
 */

class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var string
    *
    * @ORM\Column(name="PhotoPath", type="string")
    * @Assert\NotBlank(message="Please, upload the product brochure as a jpeg file.")
    * @Assert\File(mimeTypes={ "image/jpeg" })
    */
    private $PhotoPath;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get photoPath
     *
     * @return string
     */
    public function getPhotoPath()
    {
        return $this->PhotoPath;
    }
    /**
    * Set photoPath
    *
    * @param string $path
    *
    * @return string
    */
    public function setPhotoPath($path)
    {
        $this->PhotoPath = $path;

        return $this;
    }
}
