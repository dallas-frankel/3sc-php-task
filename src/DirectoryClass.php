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

  public function getParentDirectory(){
    return $this->parentDirectory;
  }

  public function getFiles(){
    return $this->files;
  }

  public function addToFiles(FileInterface $file){
    array_push($files,$file);
  }

  //removes specific file from files array
  public function removeFile(FileInterface $file){
    $arrayKey = array_search($directory);
    if($arrayKey != null){
      unset($directories[$arrayKey]);
      //for testing
      echo "File succesfully removed";
    }else{
      echo "Problem with arrayKey";
    }
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

  public function __construct($name, $parentDirectory){
      $this->setName($name);
      $this->setPath($parentDirectory);
      $directories = array();
      $files = array();
      //sets created date and time to currentTime
      $this->setCreatedTime(new \DateTime());
    
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
    $parentDirectory->deleteChildDirectory($this);
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

  private $path;

  public function getPath(){
    return $this->path;
  }
  
  //Sets the path variable using parent directory (Will make it easy to move files around later)
  public function setPath($parentDirectory){
    $this->parentDirectory = $parentDirectory;
    $path = $this->getName();
    $nextDir = $parentDirectory;
    //Moves up the parents adding each name to the path until null(Root) directory is hit
    while ($nextDir != null){
      $path = $nextDir->getName() . '/' . $path;
      $nextDir = $nextDir->getParentDirectory();
    }
    $this->path = $path;
  }
}

//For Testing
$topDir = new Directory("FirstFolder",null);
$middleDir = new Directory("MiddleFolder",$topDir);
$bottomDir = new Directory("LastFolder",$middleDir);
echo $bottomDir->getPath();

?>
