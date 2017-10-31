<?php

namespace Tonik\CLI\Scaffolding;

use RuntimeException;

class PackagesAdder
{
    /**
     * Path to the `package.json` file.
     *
     * @var string
     */
    protected $file;

    /**
     * Construct adder.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Adds additional entries to the `dependencies` option.
     *
     * @param array $dependencies
     * @return void
     */
    public function addDependencies(array $dependencies)
    {
        $this->add('dependencies', $dependencies);
    }

    /**
     * Adds additional entries to the `devDependencies` option.
     *
     * @param array $dependencies
     * @return void
     */
    public function addDevDependencies(array $dependencies)
    {
        $this->add('devDependencies', $dependencies);
    }

    /**
     * Adds additional entries to the specifed option field.
     *
     * @param array $dependencies
     * @return void
     */
    public function add($field, array $dependencies)
    {
        if (! file_exists($this->file)) {
            throw new RuntimeException("Could not add dependencies, `package.json` file do not exists.");
        }

        $packages = json_decode(file_get_contents($this->file), true);

        $packages[$field] = $dependencies + $packages[$field];

        ksort($packages[$field]);

        file_put_contents($this->file, json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL);
    }
}
