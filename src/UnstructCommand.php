<?php

namespace Jotapegue\Scaffold;

use Illuminate\Support\Str;

class UnstructCommand
{
    protected $arguments;
    protected $model;

    public function __construct(array $arguments) {
        $this->arguments = $arguments;
        $this->setModel();
    }

    private function setModel()
    {
        $this->model = $this->arguments[0];
    }

    public function getModel() : string
    {
        return Str::ucfirst($this->model);
    }

    public function getTable() : string
    {
        return Str::plural($this->model);
    }

    public function listAttributes() : array
    {
        $references = array_filter($this->arguments,
            fn ($item) => preg_match('/:/i', $item)
        );

        sort($references);

        return $references;
    }

    public function listAttributesWithoutReferences() : array
    {
        $references = array_filter($this->listAttributes(),
            fn ($item) => !preg_match('/:references/i', $item)
        );
        
        sort($references);

        return $references;
    }

    public function listAttributesWithReferences() : array
    {
        $references = array_filter($this->listAttributes(),
            fn ($item) => preg_match('/:references/i', $item)
        );
        
        sort($references);

        return $references;
    }

    public function separateColumnAndType(array $list)
    {
        return array_map(fn($item) => explode(':', $item), $list);
    }
}