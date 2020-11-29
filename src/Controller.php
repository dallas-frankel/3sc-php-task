<?php

namespace Tsc\CatStorageSystem;

require_once('FileSystemClass.php');
require_once('DirectoryClass.php');
require_once('FileClass.php');

$fileSystem = new FileSystem();
$rootDirectory = new Directory("Root");
$baseDirectory = new Directory("Folder1");
$base2Directory = new Directory("Folder2");
$baseChildDirectory = new Directory("baseChildDirectory");
$baseChildFile = new File("File1",1);


$fileSystem->createRootDirectory($rootDirectory);
$fileSystem->createDirectory($baseDirectory,$rootDirectory);
$fileSystem->createDirectory($base2Directory,$rootDirectory);
//$fileSystem->createDirectory($baseChildDirectory,$baseDirectory);
$fileSystem->createFile($baseChildFile,$rootDirectory);
//$fileSystem->createFile($baseChildFile,$baseDirectory);
//$fileSystem->createFile($baseChildFile,$rootDirectory);
//$fileSystem->createFile($baseChildFile,$base2Directory);
//$fileSystem->createFile($baseChildFile,$base2Directory);



//$hello = $fileSystem->getDirectorySize($rootDirectory);
//$fileSystem->getFiles($baseDirectory);

$currentDirectory;

//Removes all spaces and adds each work into the array
function turnInputIntoWordArray($line){
  return explode(" ",strtolower($line));
}


function menu(){
  printDirectoryContents();
  echo "\nPlease enter a command (Type 'help' for a list of commands): ";
  $handle = fopen ("php://stdin","r");
  $line = fgets($handle);
  $wordArray = turnInputIntoWordArray(trim($line));
  if(count($wordArray) > 0){
    switch ($wordArray[0]) {
      case "moveto":
          if(count($wordArray) > 1){
            changeDirectory($wordArray[1]);
          }else{
            echo "\nPlease use command as 'moveto <DirectoryName>'";
          }
          menu();
      case "moveup":
        moveup();
      case "renamefile":
          if(count($wordArray) > 2){
            renameFile($wordArray[1],$wordArray[2]);
          }else{
            echo "\nPlease use command as 'renamefile <FileName> <NewFileName>'";
          }
          menu();
      case "renamedirectory":
          if(count($wordArray) > 2){
            renameDirectory($wordArray[1],$wordArray[2]);
          }else{
            echo "\nPlease use command as 'renamedir <DirectoryName> <NewDirectoryName>'";
          }
          menu();
      case "fileproperties":
          if(count($wordArray) > 1){
            fileProperties($wordArray[1]);
          }else{
            echo "\nPlease use command as 'properties <FileName>'";
          }
        menu();
      case "directoryproperties":
          if(count($wordArray) > 1){
            directoryproperties($wordArray[1]);
          }else{
            echo "\nPlease use command as 'properties <FileName>'";
          }
        menu();
      case "deletefile":
          if(count($wordArray) > 1){
            deleteFile($wordArray[1]);
          }else{
            echo "\nPlease use command as 'properties <FileName>'";
          }
        menu();
      case "deletedirectory":
          if(count($wordArray) > 1){
            deleteDirectory($wordArray[1]);
          }else{
            echo "\nPlease use command as 'properties <FileName>'";
          }
        menu();
      case "viewfile":
        if(count($wordArray) > 1){
          viewFile($wordArray[1]);
        }else{
          echo "\nPlease use command as 'properties <FileName>'";
        }
        menu();
      case "changefileref":
        if(count($wordArray) > 2){
           changeFileRef($wordArray[1],$wordArray[2]);
        }else{
          echo "\nPlease use command as 'properties <FileName>'";
        }
          menu();
      case "quit":
        exit;
      case "help":
          echo "\n'moveto <DirectoryName>'                      : Change Directroy";
          echo "\n'moveup'                                      : Go Up One DirectoryLevel";
          echo "\n'renamefile <FileName> <NewFileName>'         : Rename a File";
          echo "\n'renamedir <DirectoryName> <NewDirectoryName>': Rename a Directory";
          echo "\n'fileproperties <FileName>'                   : Show File Properties";
          echo "\n'directoryproperties <DirectoryName>'         : Show Directory Properties";
          echo "\n'deletefile <FileName>'                       : Deletes a File";
          echo "\n'deletedirectory <DirectoryName>'             : Deletes a Directory";
          echo "\n'changefileref <FileName> <LocalFilePath>'    : Changes the Gif associated with the file";
          echo "\n'quit'                                        : Stop Execution";    
          echo "\n'help'                                        : Get a list of commands";             
          menu();
      default:
        echo "Command was not recognised";
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

//Opens the file in browser
function viewFile($fileName){
  global $fileSystem;
  $file = findFileWithName($fileName);
  if($file != null){
    $fileSystem->viewFile($file);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function changeFileRef($fileName,$newPath){
  global $fileSystem;
  $file = findFileWithName($fileName);
  if($file != null){
    $fileSystem->changeFileRef($file,$newPath);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

//Moves up one level directory
function moveup(){
  global $currentDirectory;
  if($currentDirectory->getParentDirectory() != null){
    $currentDirectory = $currentDirectory->getParentDirectory();
  }else{
    echo "Already at top directory";
  }
}

//Displays the file properties
function fileProperties($fileName){
  global $fileSystem;
  $file = findFileWithName($fileName);
  if($file != null){
    echo "------";
    echo "\nFile Properties for " . $fileName;
    echo "\nPath: " . $fileSystem->getFilePath($file);
    echo "\nSize: " . $fileSystem->getFileSize($file);
    echo "\nCreatedTime: " . $fileSystem->getFileCreationTime($file);
    echo "\nModifiedTime: " . $fileSystem->getFileModifiedTime($file);
    echo "\n------";
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function directoryProperties($directoryName){
  global $fileSystem;
  $directory = findDirectoryWithName($directoryName);
  if($directory != null){
    echo "------";
    echo "\nDirectory Properties for " . $directoryName;
    echo "\nPath: " . $directory->getPath();
    echo "\nSize: " . $fileSystem->getDirectorySize($directory);
    echo "\nCreatedTime: " . $directory->getCreatedTime();
    echo "\n------";
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function deleteDirectory($directoryName){
  global $fileSystem;
  $directory = findDirectoryWithName($directoryName);
  if($directory != null){
    $fileSystem->deleteDirectory($directory);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function deleteFile($fileName){
  global $fileSystem;
  $file = findFileWithName($fileName);
  if($file != null){
    $fileSystem->deleteFile($file);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function renameFile($fileName,$newFileName){
  global $fileSystem;
  $file = findFileWithName($fileName);
  if($file != null){
    $fileSystem->renameFile($file,$newFileName);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
}

function renameDirectory($directoryName,$newDirectoryName){
  global $fileSystem;
  $directory = findDirectoryWithName($directoryName);
  if($directory != null){
    $fileSystem->renameDirectory($directory,$newDirectoryName);
  }else{
    echo "File with this name doesn't exist in the current directory";
  }
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
  global $currentDirectory;
  global $fileSystem;
  $myfile = null;
  for($i= 0; $i < count($fileSystem->getFiles($currentDirectory));$i++){
    if(strtolower($fileSystem->getFiles($currentDirectory)[$i]->getName()) == $name){
      $myfile = $fileSystem->getFiles($currentDirectory)[$i]; 
    }
  }
  return $myfile;
}

function findDirectoryWithName($name){
  global $currentDirectory;
  global $fileSystem;
  $directory;
  for($i= 0; $i < count($fileSystem->getDirectories($currentDirectory));$i++){
    if(strtolower($fileSystem->getDirectories($currentDirectory)[$i]->getName()) == $name){
      $directory = $fileSystem->getDirectories($currentDirectory)[$i]; 
    }
  }
  return $directory;
}


function printDirectoryContents(){
  global $currentDirectory;
  echo "\nViewing " . $currentDirectory->getPath() . " Folder";
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
    echo "\n " . $line;
  }
}
function listCurrentDirectories(){
  global $currentDirectory;
  global $fileSystem;
  for($i = 0; $i < count($fileSystem->getDirectories($currentDirectory));$i++){
    $line = $fileSystem->getDirectories($currentDirectory)[$i]->getName();
    echo "\n ".$line;
  }
}
$currentDirectory = $rootDirectory;
//findFileWithName("File1");
start($rootDirectory);
?>
