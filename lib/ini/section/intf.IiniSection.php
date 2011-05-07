<?php
namespace de\hamsta\iniparser4php\ini\section;
use de\hamsta\iniparser4php\ini\property,
    de\hamsta\iniparser4php\ini\file;

/**
 *
 * @author hamsta
 */
interface IiniSection {
    private $SectionName;
    private $Properties;
    private $ParentIniFile;


    public function getProperty($PropertyKey);

    public function setProperty(property\iniProperty $iniProperty);

    public function getNextSection();

    public function getPreviousSection();

    public function setSectionName($SectionName);

    public function getSectionName();

    public function getProperties();

    public function getParentIniFile();

    public function setParentIniFile(file\IiniFile $ParentIniFile);

}
?>
