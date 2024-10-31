<?php

namespace SchemaGen;

class Parser
{
    protected $lexer;
    protected $tokens;
    protected $position;

    public function parse($input)
    {
        $this->lexer = new Lexer();
        $this->lexer->setInput($input);

        $this->tokens = [];
        while (($token = $this->lexer->moveNext()) !== null) {
            $this->tokens[] = $this->lexer->lookahead;
        }

        $this->position = 0;
        $models = [];

        while ($this->position < count($this->tokens)) {
            $models[] = $this->parseModel();
        }

        return $models;
    }

    protected function parseModel()
    {
        $model = [
            'name' => '',
            'type' => '',
            'properties' => [],
            'computed_properties' => [],
            'relationships' => [],
            'methods' => [],
            'data' => [],
            'components' => [],
        ];

        $token = $this->tokens[$this->position];

        if ($token['type'] === 'T_MODEL') {
            $model['name'] = trim(substr($token['value'], strpos($token['value'], '@') + 1));
            $model['type'] = 'model';
            $this->position++;
        } elseif ($token['type'] === 'T_COMPONENT') {
            $model['name'] = trim(substr($token['value'], strlen('@Component')));
            $model['type'] = 'component';
            $this->position++;
        }

        return $model;
    }
}
