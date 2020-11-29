<?php

namespace Tsc\CatStorageSystem;

require_once('FileInterface.php');
use \DateTimeInterface;


class File implements FileInterface {
    
    private $name;
    private $size;
    private $createdTime;
    private $modifiedTime;
    private $parentDirectory;

    public function deleteFile(){
        $this->parentDirectory->removeFile($this);
        $this->parentDirectory = null;
    }

    public function __construct($name,$size){
        $this->setName($name);
        $this->setSize($size);
        //sets created date and time to currentTime
        $this->setCreatedTime(new \DateTime());
    }

    public function getParentDirectory(){
        return $this->parentDirectory;
    }

    public function setParentDirectory(DirectoryInterface $parent){
        $this->parentDirectory = $parent;
        return $this;
    }

    //Interface Methods

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }


    public function getSize(){
        return $this->size;
    }

    public function setSize($size){
        $this->size = $size;
        return $this;
    }


    public function getCreatedTime(){
        return $this->createdTime->format('Y-m-d H:i:s');
    }

    public function setCreatedTime(DateTimeInterface $created){
        $this->createdTime = $created;
        return $this;
    }


    public function getModifiedTime(){
        if($this->modifiedTime != null){
            return $this->modifiedTime->format('Y-m-d H:i:s');
        }else{
            return $this->getCreatedTime();
        }
    }

    public function setModifiedTime(DateTimeInterface $modified){
        $this->modifiedTime = $modified;
        return $this;
    }

    public function getPath(){
        return $this->getParentDirectory()->getPath() . "/" . $this->getName();
    }

}

//For Testing
//$testObject = new File();
//$testObject->setName("Steve");
//$newName = $testObject->getName();
//echo $newName;
?>