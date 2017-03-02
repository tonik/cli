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
    protected $ignore = [
        "node_modules",
        "vendor",
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
        return $this->finder->files()
            ->name('*.php')
            ->name('*.css')
            ->name('*.json')
            ->exclude($this->ignore)
            ->in($this->dir);
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
