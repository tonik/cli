<?php

namespace Tonik\CLI\Renaming;

use Closure;
use Symfony\Component\Finder\Finder;

class Renamer
{
    /**
     * Directory path where shaking will proceed.
     *
     * @var string
     */
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
     * Files to search.
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

    /**
     * Construct shaker.
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Process renaming in files content.
     *
     * @param  array  $answers
     *
     * @return void
     */
    public function replace(array $replacements)
    {
        foreach ($this->files() as $file) {
            (new Replacer($file))->swap($replacements);
        }
    }

    /**
     * Finds files to rename.
     *
     * @return array
     */
    public function files()
    {
        $files = (new Finder)->files();

        foreach ($this->ignoredFiles as $name) {
            $files->notName($name);
        }

        foreach ($this->searchedFiles as $name) {
            $files->name($name);
        }

        return $files->exclude($this->ignoredDirectories)->in($this->dir);
    }
}
