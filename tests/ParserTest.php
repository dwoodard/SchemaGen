<?php

namespace SchemaGen\Tests;

use PHPUnit\Framework\TestCase;
use SchemaGen\Parser;

class ParserTest extends TestCase
{
    public function testParseModel()
    {
        $input = '@@ Dog - id: integer, primary_key - name: string, required';
        $parser = new Parser();
        $models = $parser->parse($input);

        $this->assertCount(1, $models);
        $this->assertEquals('Dog', $models[0]['name']);
    }
}
