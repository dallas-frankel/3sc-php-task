<?php

namespace Tsc\CatStorageSystem;

use PHPUnit\Framework\TestCase;

require_once('FileSystemClass.php');
require_once('DirectoryClass.php');
require_once('FileClass.php');
class FileSystemClassTest{

    private $baseFilePath = "C:/xampp/htdocs/3sc/images/";
    private $firstCatGif = "\cat_1.gif";
    private $secondCatGif = "\cat_2.gif";
    private $thirdCatGif = "\cat_3.gif";
    
    public function start(){
        //Gets the current \src file path and changes it to \images
        $this->baseFilePath = dirname(getcwd()) . '\images';
        $this->runTests();
    }
    
    public function runTests(){
        $bool = true;
        if(!$this->testRenameFile()){
            echo "testRenameFile Failed!";
            $bool = false;
        }

        if(!$this->testCreateFile()){
            echo "testCreateFile Failed!";
            $bool = false;
        }

        if(!$this->testDeleteFile()){
            echo "testDeleteFile Failed!";
            $bool = false;
        }

        if(!$this->testCreateDirectory()){
            echo "testCreateDirectory Failed!";
            $bool = false;
        }
        
        if(!$this->testCreateDirectory()){
            echo "testCreateDirectory Failed!";
            $bool = false;
        }
        if(!$this->testDeleteDirectory()){
            echo "testDeleteDirectory Failed!";
            $bool = false;
        }
        if(!$this->testRenameDirectory()){
            echo "testRenameDirectory Failed!";
            $bool = false;
        }

        if(!$this->testRenameDuplicate()){
            echo "testRenameDuplicate Failed!";
            $bool = false;
        }

        if(!$this->testRenameDuplicateFile()){
            echo "testRenameDuplicateFile Failed!";
            $bool = false;
        }
        
        if(!$this->testCreateFileDuplicate()){
            echo "testCreateFileDuplicate Failed!";
            $bool = false;
        }

        if(!$this->testCreateDirectoryDuplicate()){
            echo "testCreateDirectoryDuplicate Failed!";
            $bool = false;
        }

        if(!$this->testGetFileSize()){
            echo "testGetFileSize Failed!";
            $bool = false;
        }

        if(!$this->testCreationTime()){
            echo "testCreationTime Failed!";
            $bool = false;
        }

        if(!$this->testUpdateFile()){
            echo "testUpdateFile Failed!";
            $bool = false;
        }

        if(!$this->testDirectorySize()){
            echo "testDirectorySize Failed!";
            $bool = false;
        }

        if(!$this -> testGetFilePath()){
            echo "testGetFilePath Failed!";
            $bool = false;
        }

        if(!$this -> testChangeFileRef()){
            echo "testChangeFileRef Failed!";
            $bool = false;
        }

        if($bool){
            echo "\nAll Tests Returned True";
        }
    }

    public function testRenameFile(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $fileSystem = new FileSystem();
        $fileSystem->renameFile($testFile,"File2");
        if($testFile->getName() == "File2"){
            return true;
        }else{
            return false;
        }
    }

    public function testCreateFile(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testDirectory = new Directory("Folder1");
        $fileSystem = new FileSystem();
        $fileSystem->createFile($testFile,$testDirectory);
        if($testFile->getParentDirectory() == $testDirectory){
            if($testDirectory->getFiles()[0] != null){
                if($testDirectory->getFiles()[0] == $testFile){
                    return true;
                }
            }
        }
        return false;
    }

    public function testDeleteFile(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testDirectory = new Directory("Folder1");
        $fileSystem = new FileSystem();
        $fileSystem->createFile($testFile,$testDirectory);
        $fileSystem->deleteFile($testFile);
        if($testFile->getParentDirectory() == null){
            if(count($testDirectory->getFiles()) == 0){
                return true;
            }
        }
        return false;
    }

    public function testCreateDirectory(){
        $testDirectory = new Directory("TopFolder");
        $testDirectory2 = new Directory("BottomFolder");
        $fileSystem = new FileSystem();
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        if($testDirectory->getDirectories()[0] == $testDirectory2){
            if($testDirectory2->getParentDirectory() == $testDirectory){
                return true;
            }
        }
        return false;
    }

    public function testDeleteDirectory(){
        $testDirectory = new Directory("TopFolder");
        $testDirectory2 = new Directory("MiddleFolder");
        $testDirectory3 = new Directory("BottomFolder");
        $fileSystem = new FileSystem();
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->createDirectory($testDirectory3,$testDirectory2);
        $fileSystem->deleteDirectory($testDirectory2);
        if($testDirectory2->getParentDirectory() == null){
            if(count($testDirectory->getDirectories()) == 0){
                if($testDirectory3->getParentDirectory() == null){
                    return true;
                }
            }
        }
        return false;
      }

      public function testRenameDirectory(){
        $testDirectory2 = new Directory("BottomFolder");
        $testDirectory = new Directory("BottomFolder");
        $fileSystem = new FileSystem();
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->renameDirectory($testDirectory,"TopFolder");
        if($testDirectory->getName() == "TopFolder"){
            return true;
        }else{
            return false;
        }
      }

      public function testRenameDuplicate(){
        $testDirectory2 = new Directory("BottomFolder");
        $testDirectory = new Directory("TopFolder");
        $testDirectory3 = new Directory("OtherFolder");
        $fileSystem = new FileSystem();
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->createDirectory($testDirectory3,$testDirectory);
        $fileSystem->renameDirectory($testDirectory3,"BottomFolder");

        if($testDirectory3->getName() == "BottomFolder(1)"){
            return true;
        }else{
            return false;
        }
      }

      public function testRenameDuplicateFile(){
        $testDirectory = new Directory("BottomFolder");
        $testFile = new File("MyFile",$this->baseFilePath . $this->firstCatGif);
        $testFile2 = new File("MyFile1",$this->baseFilePath . $this->firstCatGif); 
        $fileSystem = new FileSystem();
        $fileSystem->createFile($testFile,$testDirectory);
        $fileSystem->createFile($testFile2,$testDirectory);
        $fileSystem->renameFile($testFile2,"MyFile");

        if($testFile2->getName() == "MyFile(1)"){
            return true;
        }else{
            return false;
        }
      }

      public function testCreateFileDuplicate(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testFile2 = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testDirectory = new Directory("Folder1");
        $fileSystem = new FileSystem();
        $fileSystem->createFile($testFile,$testDirectory);
        $fileSystem->createFile($testFile2,$testDirectory);
        if($testFile2->getParentDirectory() == $testDirectory){
            if($testDirectory->getFiles()[1] != null){
                if($testDirectory->getFiles()[1] == $testFile2){
                    if($testFile2->getName() == "File1(1)")
                        return true;
                }
            }
        }
        return false;
    }

    public function testCreateDirectoryDuplicate(){
        $testDirectory = new Directory("TopFolder");
        $testDirectory2 = new Directory("BottomFolder");
        $testDirectory3 = new Directory("BottomFolder");
        $fileSystem = new FileSystem();
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->createDirectory($testDirectory3,$testDirectory);
        if($testDirectory->getDirectories()[1] == $testDirectory3){
            if($testDirectory3->getParentDirectory() == $testDirectory){
                if($testDirectory3->getName() == "BottomFolder(1)"){
                    return true;
                }
            }
        }
        return false;
    }

    public function testGetFileSize(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $fileSystem = new FileSystem();
        if($fileSystem->getFileSize($testFile) == filesize($this->baseFilePath . $this->firstCatGif)){
            return true;
        }

        return false;
    }

    public function testCreationTime(){
        $dateTime = new \DateTime();
        $timeNow = $dateTime->format('Y-m-d H:i:s');
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $fileSystem = new FileSystem();
        //Checks if file time is set to time now
        if($testFile->getCreatedTime() == $timeNow){
            return true;
        }
        return false;      
    }

    public function testUpdateFile(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $fileSystem = new FileSystem();
        $dateTime = new \DateTime();
        $timeNow = $dateTime->format('Y-m-d H:i:s');
        $fileSystem->updateFile($testFile);
        //Checks if file time is set to time now
        if($timeNow == $fileSystem->getFileModifiedTime($testFile)){
            return true;
        }
        return false;
    }

    public function testDirectorySize(){
        $testFile = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testFile2 = new File("File1",$this->baseFilePath . $this->firstCatGif);
        $testDirectory = new Directory("TopFolder");
        $testDirectory2 = new Directory("MiddleFolder");
        $testDirectory3 = new Directory("BottomFolder");
        $fileSystem = new FileSystem();
        //Makes a chain of directories and files to test with
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->createDirectory($testDirectory3,$testDirectory2);
        $fileSystem->createFile($testFile, $testDirectory);
        $fileSystem->createFile($testFile2, $testDirectory);
        $fileSystem->createFile($testFile, $testDirectory2);
        $fileSystem->createFile($testFile, $testDirectory3);

        $sizeOfAllFiles = $testFile->getSize() * 4;
        if($fileSystem->getDirectorySize($testDirectory) == $sizeOfAllFiles){
            return true;
        }
        return false;
    }

    public function testGetFilePath(){
        $fileSystem = new FileSystem();
        $testDirectory = new Directory("TopFolder");
        $testDirectory2 = new Directory("MiddleFolder");
        $testDirectory3 = new Directory("BottomFolder");
        $testFile = new File("TestFile",$this->baseFilePath . $this->firstCatGif);
        $fileSystem->createDirectory($testDirectory2,$testDirectory);
        $fileSystem->createDirectory($testDirectory3,$testDirectory2);
        $fileSystem->createFile($testFile, $testDirectory3);
        if($fileSystem->getFilePath($testFile) == "TopFolder/MiddleFolder/BottomFolder/TestFile"){
            return true;
        }

        return false;
    }

    public function testChangeFileRef(){
        $fileSystem = new FileSystem();
        $testFile = new File("TestFile",$this->baseFilePath . $this->firstCatGif);
        $fileSystem->changeFileRef($testFile,$this->baseFilePath . $this->firstCatGif);
        if($testFile->getGifRefrence() == $this->baseFilePath . $this->firstCatGif){
            return true;
        }
        
        return false;
        

    }
}

$testClass = new FileSystemClassTest();
$testClass->start();
