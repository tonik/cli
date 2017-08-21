<?php

namespace Tonik\CLI\Scaffolding;

use League\CLImate\CLImate;
use Tonik\CLI\Scaffolding\Presets\Foundation;

class Scaffolder
{
    /**
     * Construct scaffolder.
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function build($preset)
    {
        return $this->{$preset}();
    }

    protected function foundation()
    {
        return (new Foundation($this->dir))->scaffold();
    }

    protected function none()
    {
        //
    }
}
