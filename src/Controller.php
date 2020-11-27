<?php

namespace Tsc\CatStorageSystem;

require_once('FileSystemClass.php');
require_once('DirectoryClass.php');
require_once('FileClass.php');

$fileSystem = new FileSystemClass();
$rootDirectory = new DirectoryClass("RootDir",null);
$baseDirectory = new DirectoryClass("Base1",$rootDirectory);
$base2Directory = new DirectoryClass("Base2",$rootDirectory);
$baseChildDirectory = new DirectoryClass("Base1Child",$baseDirectory);
$baseChildFile = new File("Base1File",54);


$fileSystem->createRootDirectory($rootDirectory);
$fileSystem->createDirectory($baseDirectory,$rootDirectory);
$fileSystem->createDirectory($base2Directory,$rootDirectory);
$fileSystem->createDirectory($baseChildDirectory,$baseDirectory);
$fileSystem->createFile($baseChildFile,$baseDirectory);

echo $fileSystem->getDirectorySize($rootDirectory);


?>
