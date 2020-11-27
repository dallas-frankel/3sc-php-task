<?php

namespace Tsc\CatStorageSystem;

use \DateTimeInterface;
require_once('DirectoryInterface.php');
require_once('FileInterface.php');

class Directory implements DirectoryInterface
{
  private $directoryName;
  private $createdTime;
  private $parentDirectory;

  //Arrays
  private $files;
  private $directories;

  public function getFiles(){
    return $this->files;
  }

  public function addToFiles(FileInterface $file){
    array_push($files,$file);
  }

  public function getChildrenDirectories(){
    return $this->directories;
  }


  //Adds directory to directories array
  public function addChildDirectory(DirectoryInterface $directory){
    array_push($directories,$directory);
  }

  //deletes specific directory from array
  public function deleteChildDirectory(DirectoryInterface $directory){
    $arrayKey = array_search($directory);
    if($arrayKey != null){
      unset($directories[$arrayKey]);
      //for testing
      echo "Directory succesfully deleted";
    }else{
      echo "Problem with arrayKey";
    }
  }

 

  
  //Checks if name appears in directories
  public function checkForNameInDirectories($name){
    for($i = 0; $i < count($directories);$i++){
      if($directories[$i] == $name){
        return true;
      } 
    }
    return false;
  }

  //removes directory from parrent directory array
  public function deleteDirectory(){
    $parentDirectory->deleteChildDirectory();
  }


  //Interface Methods


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
