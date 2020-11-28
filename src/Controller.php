<?php

namespace Tsc\CatStorageSystem;

require_once('FileSystemClass.php');
require_once('DirectoryClass.php');
require_once('FileClass.php');

$fileSystem = new FileSystem();
$rootDirectory = new Directory("Root");
$baseDirectory = new Directory("Folder1");
$base2Directory = new Directory("base2Directory");
$baseChildDirectory = new Directory("baseChildDirectory");
$baseChildFile = new File("Base1File",1);


$fileSystem->createRootDirectory($rootDirectory);
$fileSystem->createDirectory($baseDirectory,$rootDirectory);
//$fileSystem->createDirectory($base2Directory,$rootDirectory);
//$fileSystem->createDirectory($baseChildDirectory,$baseDirectory);
//$fileSystem->createFile($baseChildFile,$baseDirectory);
//$fileSystem->createFile($baseChildFile,$baseDirectory);
//$fileSystem->createFile($baseChildFile,$rootDirectory);
//$fileSystem->createFile($baseChildFile,$base2Directory);
//$fileSystem->createFile($baseChildFile,$base2Directory);



//$hello = $fileSystem->getDirectorySize($rootDirectory);
//$fileSystem->getFiles($baseDirectory);

$currentDirectory;


function turnInputIntoWordArray($line){
  return explode(" ", $line);
}


function menu(){
  printDirectoryContents();
  echo "\nPlease enter a command (Type 'help' for a list of commands): ";
  $handle = fopen ("php://stdin","r");
  $line = fgets($handle);
  $wordArray = turnInputIntoWordArray(trim($line));
  if(count($wordArray) > 0){
    switch ($wordArray[0]) {
      case "cd":
          if(count($wordArray) > 1){
            changeDirectory($wordArray[1]);
          }else{
            echo "\nPlease use command as 'cd <DirectoryName>'";
          }
          menu();
      case "back":
        //back();
      case "renamefile":
          if(count($wordArray) > 2){
            //renameFile($wordArray[1]);
          }else{
            echo "\nPlease use command as 'renamefile <FileName> <NewFileName>'";
          }
          menu();
      case "renamedir":
          if(count($wordArray) > 2){
            //renameDirectory($wordArray[1]);
          }else{
            echo "\nPlease use command as 'renamedir <DirectoryName> <NewDirectoryName>'";
          }
          menu();
      case "properties":
          if(count($wordArray) > 1){
            //getproperties($wordArray[1]);
          }else{
            echo "\nPlease use command as 'properties <FileName>'";
          }
        menu();
      case "quit":
        exit;
      case "help":
          echo "\n'cd <DirectoryName>'                          : Change Directroy";
          echo "\n'back'                                        : Go Up One DirectoryLevel";
          echo "\n'renamefile <FileName> <NewFileName>'         : Rename a File:";
          echo "\n'renamedir <DirectoryName> <NewDirectoryName>': Rename a Directory";
          echo "\n'properties <FileName>'                       : Show File Properties";
          echo "\n'quit'                                        : StopExecution";    
          echo "\n'help'                                        : Get a list of commands";             
          menu();
    }
  }
  fclose($handle);
  echo "Quitting";
}

function start($rootDirectory){
  global $currentDirectory;
  $currentDirectory = $rootDirectory;
  menu();
}

function changeDirectory($name){
  global $currentDirectory;
  $directory = findDirectoryWithName($name);
  if($directory != null){
    $currentDirectory = $directory;
  }else{
    echo "Directory not found in current directory";
  }
}

function findFileWithName($name){
  $file;
  for($i= 0; $i < count($fileSystem->getFiles($currentDirectory));$i++){
    if($fileSystem->getFiles($currentDirectory)[$i]->getName() == $name){
      $file = getFiles($currentDirectory)[$i]; 
    }
  }
  return $file;
}

function findDirectoryWithName($name){
  global $currentDirectory;
  global $fileSystem;
  $directory;
  for($i= 0; $i < count($fileSystem->getDirectories($currentDirectory));$i++){
    if($fileSystem->getDirectories($currentDirectory)[$i]->getName() == $name){
      $directory = $fileSystem->getDirectories($currentDirectory)[$i]; 
    }
  }
  return $directory;
}


function printDirectoryContents(){
  global $currentDirectory;
  echo "\nViewing " . $currentDirectory->getName() . " Folder";
  echo "\nFolders:";
  listCurrentDirectories();
  echo "\n\nFiles:";
  listCurrentFiles();
}

function listCurrentFiles(){
//modify to print files in a line??
global $currentDirectory;
global $fileSystem;

  for($i = 0; $i < count($fileSystem->getFiles($currentDirectory));$i++){
    $line = $fileSystem->getFiles($currentDirectory)[$i]->getName();
    echo "\n".$hello;
  }
}
function listCurrentDirectories(){
  global $currentDirectory;
  global $fileSystem;
  for($i = 0; $i < count($fileSystem->getDirectories($currentDirectory));$i++){
    $line = $fileSystem->getDirectories($currentDirectory)[$i]->getName();
    echo "\n".$line;
  }
}

start($rootDirectory);
?>
