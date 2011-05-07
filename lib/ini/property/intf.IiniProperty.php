<?php
namespace de\hamsta\iniparser4php\ini\property;
use de\hamsta\iniparser4php\ini\section,
    de\hamsta\iniparser4php\ini\comment;

/**
 *
 * @author hamsta
 */
interface IiniProperty {
    const VALUE_TYPE_STRING = 0;
    const VALUE_TYPE_INTEGER = 1;
    const VALUE_TYPE_FLOAT = 2;
    const VALUE_TYPE_BOOL = 4;

    private $PropertyKey;
    private $Value;
    private $ValueType;
    private $comment;
    private $ParentSection;

    public function getComment();
    
    public function setComment();

    public function getValue();

    public function setValue($value, $value_type = 0);

    public function getNextProperty();

    public function getPreviousProperty();

    public function getPropertyKey();

    public function setPropertyKey($PropertyKey);

    public function getParentSection();
    
    public function setParentSection(\ISection $ParentSection);

}
?>
