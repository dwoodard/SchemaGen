<?php

namespace SchemaGen;

use Doctrine\Common\Lexer\AbstractLexer;

class Lexer extends AbstractLexer
{
    protected function getCatchablePatterns()
    {
        // Adjust patterns to avoid regex modifier issues
        return [
            '@@?\s*\w+',            // Match @ or @@ followed by whitespace and word characters
            '[=~?$%^]+',             // Match one or more special characters
            '[\w\\\\]+',             // Match word characters and backslashes
            '"[^"]*"',               // Match content within double quotes
            "'[^']*'",               // Match content within single quotes
            '\([^)]*\)',             // Match content within parentheses
            '\[[^\]]*\]',            // Match content within brackets
            '->',                    // Match arrow notation
        ];
    }

    protected function getNonCatchablePatterns()
    {
        return [
            '\s+',                   // Match whitespace
            '.',                     // Match any character
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
