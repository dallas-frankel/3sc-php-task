<?php

namespace Tsc\CatStorageSystem;

require_once('FileSystemClass.php');
require_once('DirectoryClass.php');
require_once('FileClass.php');

$fileSystem = new FileSystem();
$rootDirectory = new Directory("RootDir");
$baseDirectory = new Directory("baseDirectory");
$base2Directory = new Directory("base2Directory");
$baseChildDirectory = new Directory("baseChildDirectory");
$baseChildFile = new File("Base1File",1);


$fileSystem->createRootDirectory($rootDirectory);
$fileSystem->createDirectory($baseDirectory,$rootDirectory);
$fileSystem->createDirectory($base2Directory,$rootDirectory);
$fileSystem->createDirectory($baseChildDirectory,$baseDirectory);
$fileSystem->createFile($baseChildFile,$baseDirectory);
$fileSystem->createFile($baseChildFile,$baseDirectory);
$fileSystem->createFile($baseChildFile,$rootDirectory);
$fileSystem->createFile($baseChildFile,$base2Directory);
$fileSystem->createFile($baseChildFile,$base2Directory);



$hello = $fileSystem->getDirectorySize($rootDirectory);
echo '<br>';
echo  "Size is " . $hello;
//$fileSystem->getFiles($baseDirectory);

?>
