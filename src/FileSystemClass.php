<?php

namespace Tsc\CatStorageSystem;
require_once('DirectoryInterface.php');
require_once('FileInterface.php');
require_once('FileSystemInterface.php');
class FileSystem implements FileSystemInterface
{
  private $rootDirectory;

  public function getRootDirectory(){
    return $this->rootDirectory;
  }

  public function getFileSize($file){
    return $file->getSize();
  }

  public function getFileCreationTime($file){
    return $file->getCreatedTime();
  }
  
  public function getFileModifiedTime($file){
    return $file->getModifiedTime();
  }

  public function getFilePath($file){
    return $file->getPath();
  }
  

  //Interface Methods

  public function createFile(FileInterface $file, DirectoryInterface $parent){
    if($parent->checkForNameInFiles($file->getName())){
      $file->setName($file->getName() . "(1)");
    }
    $file->setParentDirectory($parent);
    $parent->addToFiles($file);
  }

  public function updateFile(FileInterface $file){
    $file->setModifiedTime(new \DateTime());
  }

  public function renameFile(FileInterface $file, $newName){
    if($file->getParentDirectory() != null){
      if($file->getParentDirectory()->checkForNameInFiles($newName)){
        $newName = $newName . "(1)";
     }
    }
    $file->setName($newName);
  }

  public function deleteFile(FileInterface $file){
    $file->deleteFile();
  }

  public function createRootDirectory(DirectoryInterface $directory){
    $this->rootDirectory = $directory;
    $directory->setPath(null);
  }

  public function createDirectory(DirectoryInterface $directory, DirectoryInterface $parent){
     //Checks if name will be a duplicate in that file system 
    if($parent->checkForNameInDirectories($directory->getName())){
      //renames file if duplicate found
      $directory->setName($directory->getName() . "(1)");
    }
    //$parent->addChildDirectory($directory);
    $directory->setPath($parent);
  }

 
  public function deleteDirectory(DirectoryInterface $directory){
    $directory->deleteDirectory();
  }

  
  public function renameDirectory(DirectoryInterface $directory, $newName){
    //checks if name already exists in parent directory and modifies if true
    //echo "\n" . $directory->getParentDirectory()->getName() . " what";
    if($directory->getParentDirectory() != null){
      if($directory->getParentDirectory()->checkForNameInDirectories($newName)){
        $newName = $newName . "(1)";
      }
    }
    $directory->setName($newName);
  }

  
  public function getDirectoryCount(DirectoryInterface $directory){
    return count($directory->getDirectories());
  }

  
  public function getFileCount(DirectoryInterface $directory){
    return count($directory->getFiles());
  }

  
  public function getDirectorySize(DirectoryInterface $directory){
    return $directory->getDirectorySize();
  }

  
  public function getDirectories(DirectoryInterface $directory){
    return $directory->getDirectories();
  }

  public function getFiles(DirectoryInterface $directory){
    return $directory->getFiles();
  }
}
