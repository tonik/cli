<?php

namespace Tonik\CLI\Command;

use Closure;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\Services\Renamer;

class Shake
{
    protected $dir;

    /**
     * Directories to ignore on files finding.
     *
     * @var array
     */
    protected $ignoredDirectories = [
        'node_modules',
        'vendor',
    ];

    /**
     * Files to ignore on searching.
     *
     * @var array
     */
    protected $searchedFiles = [
        '*.php',
        '*.css',
        '*.json',
    ];

    /**
     * Files to ignore on searching.
     *
     * @var array
     */
    protected $ignoredFiles = [
        'composer.json',
        'composer.lock'
    ];

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function rename(array $answers)
    {
        foreach ($this->files() as $index => $file) {
            $renamer = new Renamer($file);

            $renamer->init($answers);
        }
    }

    public function files()
    {
        $files = $this->finder->files();

        foreach ($this->ignoredFiles as $name) {
            $files->notName($name);
        }

        foreach ($this->searchedFiles as $name) {
            $files->name($name);
        }

        return $files->exclude($this->ignoredDirectories)->in($this->dir);
    }

    /**
     * Sets the value of dir.
     *
     * @param mixed $dir the dir
     *
     * @return self
     */
    public function dir($dir)
    {
        $this->dir = $dir;

        return $this;
    }
}
