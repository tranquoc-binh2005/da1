<?php
namespace App\Http\Pipelines\Image\Pipes;

abstract class AbstractPipe
{
    protected array $options = [];
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    abstract public function handle($image);
}