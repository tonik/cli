<?php

namespace Tonik\CLI\Scaffolding;

use League\CLImate\CLImate;

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

    public static function build($preset)
    {
        return $this->{$preset}();
    }

    private function none()
    {
        //
    }
}