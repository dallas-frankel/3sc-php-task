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
    array_push($this->directories,$directory);
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
  public function deleteFile(FileInterface $file){
    $arrayKey = array_search($file);
    if($arrayKey != null){
      unset($files[$arrayKey]);
      //for testing
      echo "File succesfully deleted";
    }else{
      echo "Problem with arrayKey";
    }
  }

  public function __construct($name, $parentDirectory){
      $this->setName($name);
      $this->setPath($parentDirectory);
      $this->directories = (array) $this->directories;
      $this->files = (array) $this->files;
      //sets created date and time to currentTime
      $this->setCreatedTime(new \DateTime());
  }

  
  //Checks if name appears in directories
  public function checkForNameInDirectories($name){
    for($i = 0; $i < count($this->directories);$i++){
      if($this->directories[$i] == $name){
        return true;
      } 
    }
    return false;
  }

  
  public function deleteDirectory(){
    //deletes the child files
    for($i = 0; $i < count($files);$i++){
      $files[$i]->deleteFile();
    }
    //deletes the child directories
    for($i = 0; $i < count($directories);$i++){
      $directories[$i]->deleteDirectory();
    }
    //removes directory from parrent directory array
    $parentDirectory->deleteChildDirectory($this);
  }

  public function getDirectorySize(){
    $accumlatedSize;
    for($i = 0; $i < count($files);$i++){
      $accumlatedSize = $accumlatedSize + $files[$i]->getSize();        
    }
    for($i = 0;$i < count($directories);$i++){
      $accumlatedSize = $accumlatedSize + $directories[$i]->getDirectorySize();
    }
    return $accumlatedSize();
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
    //Maybe remove from parent here????????
    $this->parentDirectory = $parentDirectory;
    if($parentDirectory != null){
      $parentDirectory->addChildDirectory($this);
    }
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
echo $bottomDir->checkForNameInDirectories("LastFolder");

?>
