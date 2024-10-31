<?php

namespace SchemaGen;

use Doctrine\Common\Lexer\AbstractLexer;

class Lexer extends AbstractLexer
{
    protected function getCatchablePatterns()
    {
        return [
            '@@?\s*\w+',
            '[=~?$%^]+',
            '[\w\\\\]+',
            '"[^"]*"',
            "'[^']*'",
            '\([^)]*\)',
            '\[[^\]]*\]',
            '->',
        ];
    }


    protected function getNonCatchablePatterns()
    {
        return [
            '\s+',                   // Match whitespace
            // Removed '.' pattern to fix regex error
        ];
    }

    protected function getType(&$value)
    {
        $trimmedValue = trim($value);

        if (preg_match('/^@@?\s*(\w+)/', $trimmedValue)) {
            return 'T_MODEL';
        } elseif (preg_match('/^@Component\s*(\w+)/', $trimmedValue)) {
            return 'T_COMPONENT';
        } elseif (preg_match('/^-/', $trimmedValue)) {
            return 'T_PROPERTY';
        } elseif (preg_match('/^=/', $trimmedValue)) {
            return 'T_COMPUTED_PROPERTY';
        } elseif (preg_match('/^>/', $trimmedValue)) {
            return 'T_RELATIONSHIP';
        } elseif (preg_match('/^---+/', $trimmedValue)) {
            return 'T_SEPARATOR';
        } elseif ($trimmedValue === '') {
            return 'T_END';
        } else {
            return 'T_STRING';
        }
    }
}
