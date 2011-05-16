<?php

require_once 'class.iniFile.php';
require_once 'class.iniParser.php';

/**
 * Description of class
 *
 * @author hamsta
 */
class iniSection {

    protected $valueRegex = <<<'VREG'
/
^[\s]*\[(.*)\](?:[\s]*[;\#](.*))[\s]*$|
^[\s]*\[(.*)\][\s]*$|
(^[\s]*[^;\#=]+)[\s]*(?:
=[\s]*\'(.*)\'(?:[\s]*[;\#](.*))[\s]*$|
=[\s]*\'(.*)\'[\s]*$|
=[\s]*"(.*)"(?:[\s]*[;\#](.*))[\s]*$|
=[\s]*"(.*)"[\s]*$|
=[\s]*([0-9]+[\.,][0-9]+)(?:[\s]*[;\#](.*))[\s]*$|
=[\s]*([0-9]+[\.,][0-9]+)[\s]*$|
=[\s]*([0-9]+)(?:[\s]*[;\#](.*))[\s]*$|
=[\s]*([0-9]+)[\s]*$|
=[\s]*(true|false|[01]?)(?:[;\#](.*))[\s]*$|
=[\s]*(true|false|[01]?)[\s]*$|
)|
[\s]*(?:[;\#](.*))[\s]*$
/ix
VREG;

    protected $splitRegex = <<<'SREG'
/[\n\r]+/i
SREG;
    
    private $iniParser;
    private $properties;
    private $property_comments;
    private $comments;

    public function addComment($value){
        $this->comments[] = $value;
    }


    public function __construct(iniParser $iniFile) {
        $this->setIniParser($iniFile);
    }

    public function getIniParser() {
        return $this->iniParser;
    }

    public function setIniParser(iniParser $iniParser) {
        $this->iniParser = $iniParser;
    }

    private function getProperty($key) {
        return $this->properties;
    }

    private function setProperty($key, $value, $comment='') {
        $this->properties[$key] = $value;
    }

    public function getProperty_comment($key) {
        return $this->property_comments[$key];
    }

    public function setProperty_comment($key, $comment) {
        $this->property_comments[$key] = $comment;
    }

    public function setInteger($key, $value) {
        $value = (int)$value;
        if (is_integer($value)) {
            $this->setProperty($key, $value);
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'integer' expected but '$type' given.", E_ERROR);
        }
    }

    public function setString($key, $value) {
        $value = (string)$value;
        if (is_string($value)) {
            $this->setProperty($key, "'$value'");
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'string' expected but '$type' given.", E_ERROR);
        }
    }

    public function setFloat($key, $value) {
        $value = (double)$value;
        if (is_float($value) or is_double($value)) {
            $this->setProperty($key, $value);
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'float or double' expected but '$type' given.", E_ERROR);
        }
    }

    public function setBoolean($key, $value) {
        $value = ($value);
        if (is_bool($value)) {
            $this->setProperty($key, $value);
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'boolean' expected but '$type' given.", E_ERROR);
        }
    }

    public function getInteger($key) {
        $value = $this->getProperty($key);
        if (is_integer($value)) {
            return $value;
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'integer' expected but '$type' given.", E_ERROR);
        }
    }

    public function getString($key) {
        $value = $this->getProperty($key);
        if (is_string($value)) {
            return $value;
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'string' expected but '$type' given.", E_ERROR);
        }
    }

    public function getFloat($key) {
        $value = $this->getProperty($key);
        if (is_float($value) or is_double($value)) {
            return $value;
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'float or double' expected but '$type' given.", E_ERROR);
        }
    }

    public function getBoolean($key) {
        $value = $this->getProperty($key);
        if (is_bool($value)) {
            return $value;
        } else {
            $type = gettype($value);
            throw new Exception("Value of Type 'boolean' expected but '$type' given.", E_ERROR);
        }
    }

}
?>
