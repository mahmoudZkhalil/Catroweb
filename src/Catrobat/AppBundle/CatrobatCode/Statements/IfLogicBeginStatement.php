<?php

namespace Catrobat\AppBundle\CatrobatCode\Statements;

use Catrobat\AppBundle\CatrobatCode\SyntaxHighlightingConstants;

class IfLogicBeginStatement extends Statement
{
    const BEGIN_STRING = "if ";
    const END_STRING = ")<br/>";

    public function __construct($statementFactory, $xmlTree, $spaces)
    {
        $stmt = SyntaxHighlightingConstants::LOOP . self::BEGIN_STRING . SyntaxHighlightingConstants::END . "(";

        parent::__construct($statementFactory, $xmlTree, $spaces,
            $stmt,
            self::END_STRING);
    }

    public function getSpacesForNextBrick()
    {
        return $this->spaces + 1;
    }

}

?>
