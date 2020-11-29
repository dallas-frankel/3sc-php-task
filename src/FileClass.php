<?php

namespace Tsc\CatStorageSystem;

require_once('FileInterface.php');
use \DateTimeInterface;


class File implements FileInterface {
    
    private $name;
    private $size;
    private $createdTime;
    private $modifiedTime;
    private $parentDirectory;
    private $gifRefrence;

    //sets the path to where the gif is stored on the disk
    public function setGifRefrence($diskPath){
        if(file_exists($diskPath)){
            $this->gifRefrence = $diskPath;
            $this->setModifiedTime(new \DateTime());
        }else{
            echo "refrence path does not lead to a real file : " . $diskPath;
        }
    }

    //gets the path to where the gif is stored on the disk
    public function getGifRefrence(){
        return $this->gifRefrence;
    }

    //opens the gif at the path in the web browser
    public function viewGif(){
        if(file_exists($this->gifRefrence)){
            echo  $this->gifRefrence . " it exists";
            $url=$this->gifRefrence;
            $cmd=sprintf( 'start %s',$url );
            exec( $cmd );
        }else{
            echo "refrence path does not lead to a real file";
        }
    }

    public function deleteFile(){
        $this->parentDirectory->removeFile($this);
        $this->parentDirectory = null;
    }

    public function __construct($name,$gifRefrence){
        if(file_exists($gifRefrence)){
            $this->setName($name);
            $this->setSize(filesize($gifRefrence));
            $this->setGifRefrence($gifRefrence);
            //sets created date and time to currentTime
            $this->setCreatedTime(new \DateTime());
        }else{
            echo "File Creation Failed, Path (". $gifRefrence .") doesn't exist";
        }
        
    }

    public function getParentDirectory(){
        return $this->parentDirectory;
    }

    public function setParentDirectory(DirectoryInterface $parent){
        $this->parentDirectory = $parent;
        return $this;
    }

    //Interface Methods

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }


    public function getSize(){
        return $this->size;
    }

    public function setSize($size){
        $this->size = $size;
        return $this;
    }


    public function getCreatedTime(){
        return $this->createdTime->format('Y-m-d H:i:s');
    }

    public function setCreatedTime(DateTimeInterface $created){
        $this->createdTime = $created;
        return $this;
    }


    public function getModifiedTime(){
        if($this->modifiedTime != null){
            return $this->modifiedTime->format('Y-m-d H:i:s');
        }else{
            return $this->getCreatedTime();
        }
    }

    public function setModifiedTime(DateTimeInterface $modified){
        $this->modifiedTime = $modified;
        return $this;
    }

    public function getPath(){
        return $this->getParentDirectory()->getPath() . "/" . $this->getName();
    }

}

?>