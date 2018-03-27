<?php

namespace Tonik\CLI\Scaffolding;

use Symfony\Component\Filesystem\Filesystem;

class FilesCloner
{
    /**
     * Source directory to clone.
     *
     * @var string
     */
    protected $source;

    /**
     * Cloning options. By default it overwriting all
     * files and removes all not present in source.
     *
     * @var array
     */
    protected $options = [
        'override' => true,
        'delete' => true,
    ];

    /**
     * Construct cloner.
     *
     * @param string $source
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Perform source cloning.
     *
     * @param  string $destination
     * @return void
     */
    public function clone($destination)
    {
        $fs = new Filesystem;

        if (! $fs->exists($destination)) {
            $fs->mkdir($destination, 0755);
        }

        $fs->mirror($this->source, $destination, null, $this->options);
    }

    /**
     * Perform source coping.
     *
     * @param  string $file
     * @return void
     */
    public function copy($file)
    {
        $fs = new Filesystem;

        if (! $fs->exists(dirname($file))) {
            $fs->mkdir(dirname($file), 0755);
        }

        $fs->copy($this->source, $file, true);
    }
}
