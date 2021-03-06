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

  public function getDirectories(){
    return $this->directories;
  }

  public function addToFiles(FileInterface $file){
    array_push($this->files,$file);
  }

  //removes specific file from files array
  public function removeFile(FileInterface $file){
    $arrayKey = array_search($file,$this->files);
    if($arrayKey != null || $arrayKey == 0){
      unset($this->files[$arrayKey]);
      $this->files = array_values($this->files);
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
    $arrayKey = array_search($directory,$this->directories);
    if($arrayKey != null || $arrayKey == 0){
      unset($this->directories[$arrayKey]);
      $this->directories = array_values($this->directories);
    }else{
      echo "Problem with arrayKey";
    }
  }
  public function deleteFile(FileInterface $file){
    $arrayKey = array_search($file);
    if($arrayKey != null){
      unset($files[$arrayKey]);
      //for testing
    }else{
      echo "Problem with arrayKey";
    }
  }
  

  public function __construct($name){
      $this->setName($name);
      
      $this->directories = (array) $this->directories;
      $this->files = (array) $this->files;
      //sets created date and time to currentTime
      $this->setCreatedTime(new \DateTime());
  }

  
  //Checks if name appears in directories
  public function checkForNameInDirectories($name){
    for($i = 0; $i < count($this->directories);$i++){
      if(strtolower($this->directories[$i]->getName()) == strtolower ($name)){
        return true;
      } 
    }
    return false;
  }

  public function checkForNameInFiles($name){
    for($i = 0; $i < count($this->files);$i++){
      if(strtolower($this->files[$i]->getName()) == strtolower($name)){
        return true;
      } 
    }
    return false;
  }

  
  public function deleteDirectory(){
    
    //deletes the child files
    for($i = 0; $i < count($this->files);$i++){
      $this->files[$i]->deleteFile();
    }
    //deletes the child directories
    for($i = 0; $i < count($this->directories);$i++){
      $this->directories[$i]->deleteDirectory();
    }
    //removes directory from parrent directory array
    $this->parentDirectory->deleteChildDirectory($this);
    $this->parentDirectory = null;
  }

  public function getDirectorySize(){
    $accumlatedSize = 0;
    for($i = 0; $i < count($this->files);$i++){
      $accumlatedSize = $accumlatedSize + $this->files[$i]->getSize();        
    }
    //Recursive call going down the directory tree getting all the file sizes
    for($i = 0;$i < count($this->directories);$i++){
      $accumlatedSize = $accumlatedSize + $this->directories[$i]->getDirectorySize();
    }
    return $accumlatedSize;
  }


  //Interface Methods


  public function getName(){
    return $this->directoryName;
  }

  public function setName($name){
    $this->directoryName = $name;
  }

  public function getCreatedTime(){
    return $this->createdTime->format('Y-m-d H:i:s');
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
