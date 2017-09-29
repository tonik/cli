<?php

namespace Tonik\CLI\Scaffolding;

use RuntimeException;

class ConfigAdder
{
    /**
     * Path to the `app.json` file.
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
     * Adds additional entries to the `assets` option.
     *
     * @param array $assets
     * @return void
     */
    public function add(array $assets)
    {
        if (! file_exists($this->file)) {
            throw new RuntimeException("Could not add assets, `app.json` file do not exists.");
        }

        $packages = json_decode(file_get_contents($this->file), true);

        $packages['assets'] = $assets + $packages['assets'];

        ksort($packages['assets']);

        file_put_contents($this->file, json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL);
    }
}
