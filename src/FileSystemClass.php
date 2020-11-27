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
    $file->deleteFile();
  }

  public function createRootDirectory(DirectoryInterface $directory){
    $this->rootDirectory = $directory;
  }

  public function createDirectory(DirectoryInterface $directory, DirectoryInterface $parent){
     //Checks if name will be a duplicate in that file system 
    if(!$parent->checkForNameInDirectories($directory->getName())){
      //renames file if duplicate found
      $directory->setName($directory->getName() . "(1)");
    }
    $parent->addChildDirectory($directory);
  }

 
  public function deleteDirectory(DirectoryInterface $directory){
    $directory->deleteDirectory();
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
    $files = $directory->getFiles();
    $accumlatedSize;
    for($i = 0; $i < count($files);$i++){
      $accumlatedSize = $accumlatedSize + $files[$i]->getSize();        
    }
    return $accumlatedSize();
  }

  
  public function getDirectories(DirectoryInterface $directory){
    return $directory->getDirectories();
  }

  public function getFiles(DirectoryInterface $directory){
    return $directory->getFiles();
  }
}
