<?php

namespace Tsc\CatStorageSystem;

class FileSystem
{

  public function createFile(FileInterface $file, DirectoryInterface $parent){
   
  }

  public function updateFile(FileInterface $file){

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
      $directory->setName($directory->getName() . "1");
    }
  }

 
  public function deleteDirectory(DirectoryInterface $directory){

  }

  
  public function renameDirectory(DirectoryInterface $directory, $newName){
    $directory->setName($newName);
  }

  
  public function getDirectoryCount(DirectoryInterface $directory){

  }

  
  public function getFileCount(DirectoryInterface $directory){

  }

  
  public function getDirectorySize(DirectoryInterface $directory){

  }

  
  public function getDirectories(DirectoryInterface $directory){

  }


  public function getFiles(DirectoryInterface $directory){

  }
}
