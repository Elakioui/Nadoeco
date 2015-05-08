<?php

namespace Nadoeco\NadoecoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Media
 *
 * @ORM\Table("media")
 * @ORM\Entity(repositoryClass="Nadoeco\NadoecoBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    /**
     * @var integer

     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private  $id;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank
     */
    private $name;
    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $path;
    /**
     * @ORM\Column(name="updated_at",type="datetime", nullable= true)
     */
    private  $updateAt;

    public  $file;

    /*
     * @ORM\PostLoad()
     * */
    public function postLoad(){
       $this->updateAt = new \DateTime();
    }
    public function getUploadRootDir(){
        return __DIR__.'/../../../../web/uploads';
    }

    public function getAbsolutePath(){
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */

    public function preUpload(){
        $this->tempfile = $this->getAbsolutePath();
        $this->oldfile = $this->getPath();
        $this->updateAt = new \DateTime();

        if( null !== $this->file) $this->path = sha1(uniqid(mt_rand(),true)).'.'.$this->file->guessExtension();


    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */

    public function upload(){


        if( null !== $this->file)
        {
            $this->file->move($this->getUploadRootDir(),$this->path);
            unset($this->file);
            if( null != $this->oldfile) unlink($this->tempfile);
        }


    }
    /**
     * @ORM\PreRemove()
     */

    public function preRemoveUpload(){

         $this->tempFile = $this->getAbsolutePath();

    }
    /**
     * @ORM\PostRemove()
     */

    public function postRemoveUpload(){

       if(file_exists($this->tempFile)) unlink($this->tempFile)  ;

    }
   public function getAssetPath(){
       return 'uploads/'.$this->path;
   }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */

    public function getPath(){
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $updateAt
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }



}
