<?php

namespace Tsc\CatStorageSystem;

use \DateTimeInterface;
require_once('DirectoryInterface.php');

class Directory implements DirectoryInterface
{

  private $directoryName;
  private $createdTime;
  private $parentDirectory;
 
  public function getName(){
    return $this->directoryName;
  }

  public function setName($name){
    $this->directoryName = $name;
  }

  public function getCreatedTime(){
    return $this->$createdTime;
  }

  public function setCreatedTime(DateTimeInterface $created){
    $this->createdTime = $created;
  }

  public function getPath(){
    return $this->$path;
  }

  public function setPath($path){
    $this->path = $path;
  }
}

//For Testing
$testObject = new Directory();
$testObject->setName("Steve");
$newName = $testObject->getName();
echo $newName;
?>
