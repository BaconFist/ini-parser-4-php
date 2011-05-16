<?php

require_once 'class.iniFile.php';
require_once 'class.iniSection.php';

/**
 * Description of class
 *
 * @author hamsta
 */
class iniParser extends iniSection {

    private $iniFile;
    private $iniSection;

    public function __construct(iniFile $iniFile, $parse = true) {
        $this->setIniFile($iniFile);
        if ($parse) {
            $this->parse();
        }
    }

    /**
     *
     * @return iniFile
     */
    public function getIniFile() {
        return $this->iniFile;
    }

    public function setIniFile(iniFile $iniFile) {
        $this->iniFile = $iniFile;
    }

    /**
     *
     * @param string $key Sectionname
     * @param boolean $forceCreate create non-existing Sectoin
     * @return iniSection
     */
    public function getIniSection($key, $forceCreate = true) {
        try {
            if ($forceCreate) {
                $this->newSection($key);
            }
            if ($this->hasSection($key)) {
                return $this->iniSection[$key];
            } else {
                throw new Exception("Unknown Sectionname '$key'.", E_ERROR);
            }
        } catch (Exception $e) {
            
        }
    }

    /**
     *
     * @param string $key Sectionname
     * @return iniSection
     */
    public function newSection($key) {
        if (!$this->hasSection($key)) {
            $this->iniSection[$key] = new iniSection($this);
        }
        return $this->getIniSection($key, false);
    }

    public function hasSection($key) {
        return isset($this->iniSection[$key]);
    }

    public function getSectionsCount() {
        return count($this->iniSection);
    }

    public function getSections() {
        return $this->iniSection;
    }

    public function setIniSection($key, iniSection $iniSection) {
        $this->iniSection = $iniSection;
    }

    public function getIniParser() {

    }

    public function setIniParser() {

    }

    public function parse() {
        $content = $this->getIniFile()->getContent();
        if ($content) {
            $pattern = $this->valueRegex;
            $lastSection = false;
            $lastSectionObj = null;
            $content = preg_split($this->splitRegex, $content, -1, PREG_SPLIT_NO_EMPTY);
            $i = 0;
            foreach ($content as $line) {
                $i++;
                $match = array();
                if (preg_match($pattern, $line, $match)) {
                    $match = self::getNormalizedIniRegExMatch($match);
                    if ((!empty($match['section'])) && ($lastSection != $match['section'])) {
                        $lastSectionObj = $this->newSection($match['section']);
                    }
                    if (is_null($lastSectionObj)) {
                        $target = $this;
                    } else {
                        $target = $lastSectionObj;
                    }
                    /* @var $target iniSection|iniParser */
                    switch ($match['type']) {
                        case 'section':
                            if (!empty($match['comment'])) {
                                $target->addComment($match['comment']);
                            }
                            break;
                        case 'string':
                            $target->setString($match['property'], $match[$match['type']]);
                            break;
                        case 'boolean':
                            $target->setBoolean($match['property'], $match[$match['type']]);
                            break;
                        case 'integer':
                            $target->setInteger($match['property'], $match[$match['type']]);
                            break;
                        case 'float':
                            $target->setFloat($match['property'], $match[$match['type']]);
                            break;
                    }
                    if (($match['type'] != 'comment') && (!empty($match['comment']))) {
                        $target->setProperty_comment($match['property'], $match['comment']);
                    }
                    if (($match['type'] == 'comment') && (!empty($match['comment']))) {
                        $target->addComment($match['comment']);
                    }
                }
            }
        }
    }

    static private function getNormalizedIniRegExMatch($match) {
        $E = array(
            'type' => null,
            'comment' => null,
            'property' => null,
            'section' => null,
            'string' => null,
            'boolean' => null,
            'integer' => null,
            'float' => null
        );
        /*
         * section : 3, 1 ;2
         * property : 4
         * string : 7,10, 5,8 ;6,9
         * boolean : 19, 17 ;18
         * integer : 16, 14 ;15
         * float : 13, 11 ;12
         * comment: ;20
         */
        if (!empty($match[20])) {
            $E['comment'] = $match[20];
            $E['type'] = 'comment';
        }
        if (!empty($match[4])) {
            $E['property'] = $match[4];
        }
        if (!empty($match[3])) {
            $E['section'] = $match[3];
            $E['type'] = 'section';
        }
        if (!empty($match[1])) {
            $E['section'] = $match[1];
            $E['comment'] = $match[2];
            $E['type'] = 'section';
        }
        if (!empty($match[7])) {
            $E['string'] = $match[7];
            $E['type'] = 'string';
        }
        if (!empty($match[10])) {
            $E['string'] = $match[10];
            $E['type'] = 'string';
        }
        if (!empty($match[5])) {
            $E['string'] = $match[5];
            $E['comment'] = $match[6];
            $E['type'] = 'string';
        }
        if (!empty($match[8])) {
            $E['string'] = $match[8];
            $E['comment'] = $match[9];
            $E['type'] = 'string';
        }
        if (!empty($match[19])) {
            $E['boolean'] = $match[19];
            $E['type'] = 'boolean';
        }
        if (!empty($match[17])) {
            $E['boolean'] = $match[17];
            $E['comment'] = $match[18];
            $E['type'] = 'boolean';
        }
        if (!empty($match[16])) {
            $E['integer'] = $match[16];
            $E['type'] = 'integer';
        }
        if (!empty($match[14])) {
            $E['integer'] = $match[14];
            $E['comment'] = $match[15];
            $E['type'] = 'integer';
        }
        if (!empty($match[13])) {
            $E['float'] = $match[13];
            $E['type'] = 'float';
        }
        if (!empty($match[11])) {
            $E['float'] = $match[11];
            $E['comment'] = $match[12];
            $E['type'] = 'float';
        }
        return $E;
    }

}
?>
