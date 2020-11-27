<?php

namespace Tsc\CatStorageSystem;
require_once('DirectoryInterface.php');
require_once('FileInterface.php');
require_once('FileSystemInterface.php');
class FileSystem implements FileSystemInterface
{

  public function createFile(FileInterface $file, DirectoryInterface $parent){
    $parent->addToFiles($file);
  }

  public function updateFile(FileInterface $file){
    $file->setModifiedTime(new \DateTime());
  }

  public function renameFile(FileInterface $file, $newName){
    $file->setName($newName);
  }

  public function deleteFile(FileInterface $file){

  }

  public function createRootDirectory(DirectoryInterface $directory){

  }

  public function createDirectory(DirectoryInterface $directory, DirectoryInterface $parent){
     //Checks if name will be a duplicate in that file system 
    if(!$parent->checkForNameInDirectories($directory->getName())){
      $directory->setName($directory->getName() . "(1)");
    }
  }

 
  public function deleteDirectory(DirectoryInterface $directory){

  }

  
  public function renameDirectory(DirectoryInterface $directory, $newName){
    $directory->setName($newName);
  }

  
  public function getDirectoryCount(DirectoryInterface $directory){
    return count($directory->getDirectories());
  }

  
  public function getFileCount(DirectoryInterface $directory){
    return count($directory->getFiles());
  }

  
  public function getDirectorySize(DirectoryInterface $directory){
   
  }

  
  public function getDirectories(DirectoryInterface $directory){
    return $directory->getDirectories();
  }

  public function getFiles(DirectoryInterface $directory){
    return $directory->getFiles();
  }
}
