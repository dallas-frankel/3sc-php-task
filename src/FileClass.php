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
        $parentDirectory->removeFile($this);
    }

    public function __construct($name,$size){
        $this->setName($name);
        $this->setSize($size);
        //sets created date and time to currentTime
        $this->setCreatedTime(new \DateTime());
    }

    public function getParentDirectory(){
        return $parentDirectory;
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
        return $size;
    }

    public function setSize($size){
        $this -> $size = $size;
        return $this;
    }


    public function getCreatedTime(){
        return $createdTime;
    }

    public function setCreatedTime(DateTimeInterface $created){
        $createdTime = $created;
        return $this;
    }


    public function getModifiedTime(){
        return $modifiedTime;
    }

    public function setModifiedTime(DateTimeInterface $modified){
        $modifiedTime = $modified;
        return $this;
    }

    public function getPath(){
        return getParentDirectory() . "/" . getName();
    }

}

//For Testing
$testObject = new File();
$testObject->setName("Steve");
$newName = $testObject->getName();
echo $newName;
?>