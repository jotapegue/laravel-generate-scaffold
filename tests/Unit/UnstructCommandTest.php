<?php

namespace Jotapegue\GenerateScaffold\Tests\Unit;

use Orchestra\Testbench\TestCase;
use Jotapegue\Scaffold\UnstructCommand;

class UnstructCommandTest extends TestCase
{
    protected $arguments;
    protected $unstruct;

    protected function setUp() : void
    {
        parent::setUp();

        $this->arguments = [
            0 => "person",
            1 => "name:string",
            2 => "age:integer",
            3 => "user:references"
        ];

        $this->unstruct = new UnstructCommand($this->arguments);
    }

    /** @test */
    public function getModelFromArrray()
    {
        $this->assertEquals('Person', $this->unstruct->getModel());
    }

    /** @test */
    public function getNameTableFromModel()
    {
        $this->assertEquals('people', $this->unstruct->getTable());
    }

    /** @test */
    public function getListAttributes()
    {
        $expected = [
            0 => "age:integer",
            1 => "name:string",
            2 => "user:references",
        ];

        $this->assertEquals($expected, $this->unstruct->listAttributes());
    }

    /** @test */
    public function listAttributesWithoutReferencesReturnArray()
    {
        $expected = [
            0 => "age:integer",
            1 => "name:string",
        ];

        $this->assertEquals($expected, $this->unstruct->listAttributesWithoutReferences());
    }    

    /** @test */
    public function listAttributesWithReferencesReturnArray()
    {
        $this->assertEquals([0 => "user:references"],
            $this->unstruct->listAttributesWithReferences()
        );
    }

    /** @test */
    public function listColumnWithTypeWithoutReferences()
    {
        $expected = [
            0 => [
                0 => "age",
                1 => "integer"
            ],
            1 => [
                0 => "name",
                1 => "string"
            ]
        ];

        $this->assertEquals($expected, $this->unstruct->separateColumnAndType(
            $this->unstruct->listAttributesWithoutReferences()
        ));
    }

    /** @test */
    public function listColumnWithTypeWithReferences()
    {
        $expected = [
            0 => [
                0 => "user",
                1 => "references"
            ]
        ];

        $this->assertEquals($expected, $this->unstruct->separateColumnAndType(
            $this->unstruct->listAttributesWithReferences()
        ));
    }
}
