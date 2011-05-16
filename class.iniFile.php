<?php

require_once 'class.iniParser.php';

/**
 * Description of class
 * @license OpenSource
 * @author hamsta
 */
class iniFile {
    const AUTOSAVE_NONE = 0;
    const AUTOSAVE_LIVE = 1;
    const AUTOSAVE_DESTROY = 2;

    private $FileName;
    private $iniParser;
    private $autosave = 0;
    private $content = false;

    public function __construct($FileName, $autosave = 0) {
        $this->setAutosave($autosave);
        $this->setFileName($FileName);
        $this->getIniParser();
    }

    public function __destruct() {
        if ($this->getAutosave() & self::AUTOSAVE_DESTROY) {
            $this->save();
        }
    }

    public function saveLiveEvent() {
        if ($this->getAutosave() & self::AUTOSAVE_LIVE) {
            $this->save();
        }
    }

    public function save() {
        if (is_writeable($this->getFileName())) {
            return file_put_contents($this->getFileName(), $this->getContent());
        }
    }

    public function getAutosave() {
        return $this->autosave;
    }

    public function setAutosave($autosave) {
        $this->autosave = $autosave;
    }

    public function getFileName() {
        try {
            return $this->FileName;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function setFileName($FileName) {
        try {
            if (is_string($FileName)) {
                if (file_exists($FileName)) {
                    $this->FileName = $FileName;
                } else {
                    throw new Exception("File not found '$FileName'", E_ERROR);
                }
            } else {
                $type = is_object($FileName) ? get_class($FileName) : gettype($FileName);
                throw new Exception("Value of Type 'string' expectet but '$type' given.", E_ERROR);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @return iniParser
     */
    public function getIniParser() {
        try {
            $iniParser = $this->iniParser;
            if(!(is_object($iniParser) && ($iniParser instanceof  iniParser))){
                $this->iniParser = new iniParser($this);
            }
            return $this->iniParser;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function setIniParser($iniParser) {
        try {
            $this->iniParser = $iniParser;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function load() {
        try {
            $filename = $this->getFileName();
            if (is_readable($filename)) {
                $content = file_get_contents($filename);
                if (false !== $content) {
                    $this->setContent($content);
                } else {
                    throw new Exception("Unable to read Content of File '$filename'", E_ERROR);
                }
            } else {
                throw new Exception("File not readable. '$filename'", E_ERROR);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getContent() {
        if(false === $this->content){
            $this->load();
        }
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

}
?>
