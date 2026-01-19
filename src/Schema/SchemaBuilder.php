<?php

namespace AutoSEO\Schema;

class SchemaBuilder
{
    protected array $schemas = [];

    public function add(array $schema): self
    {
        $this->schemas[] = $schema;
        return $this;
    }

    public function get(): array
    {
        return $this->schemas;
    }
}
