<?php
namespace de\hamsta\iniparser4php\ini\comment;

/**
 *
 * @author hamsta
 */
interface IiniComment {
    
    private $CommentValue;
    protected $CommentRegex = <<<'CREG'
/^;(.*)/
CREG;

    public function getCommentValue();
    public function setCommentValue();
}
?>
