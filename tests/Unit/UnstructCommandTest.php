<?php

namespace Jotapegue\GenerateScaffold\Tests\Unit;

use Orchestra\Testbench\TestCase;
use Jotapegue\Scaffold\Services\UnstructCommand;

class UnstructCommandTest extends TestCase
{
    protected $arguments = [];
    protected UnstructCommand $unstruct;

    protected function setUp() : void
    {
        parent::setUp();

        $this->arguments = [
            "person",
            "name:string",
            "age:integer",
            "user:references"
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
            "age:integer",
            "name:string",
            "user:references",
        ];

        $this->assertEquals($expected, $this->unstruct->listAttributes());
    }

    /** @test */
    public function listAttributesWithoutReferencesReturnArray()
    {
        $expected = [
            "age:integer",
            "name:string",
        ];

        $this->assertEquals($expected, $this->unstruct->listAttributesWithoutReferences());
    }    

    /** @test */
    public function listAttributesWithReferencesReturnArray()
    {
        $this->assertEquals(["user:references"],
            $this->unstruct->listAttributesWithReferences()
        );
    }

    /** @test */
    public function listColumnWithTypeWithoutReferences()
    {
        $expected = [
            [
                "age",
                "integer"
            ],
            [
                "name",
                "string"
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
            [
                "user",
                "references"
            ]
        ];

        $this->assertEquals($expected, $this->unstruct->separateColumnAndType(
            $this->unstruct->listAttributesWithReferences()
        ));
    }
}
