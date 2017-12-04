<?php 

namespace Language\Application\Writer;

interface WriterInterface
{
    public function write(string $name, string $content);
}
