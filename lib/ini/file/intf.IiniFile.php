<?php
namespace de\hamsta\iniparser4php\ini\file;
use de\hamsta\iniparser4php\utils;
use de\hamsta\iniparser4php\ini\section;
use de\hamsta\iniparser4php\ini\comment;
use de\hamsta\iniparser4php\ini\property;

/**
 *
 * @author hamsta
 */
interface IiniFile {
   private $FileHandle;
   private $Properties;
   private $Sections;

   public function setFileHandle(utils\FileHandle $FileHandle);
   
   public function getFileHandle();
   
   public function getProperty($PropertyKey,$SectionKey = 0);
   
   public function setProperty($value,$PropertyKey,$SectionKey = 0);
   
   public function getSection($SectionKey);

   public function setSection(section\IiniSection $iniSection);


}
?>
