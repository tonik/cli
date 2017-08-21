<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\Renaming\Replacer;
use Tonik\CLI\Scaffolding\AssetsRenamer;
use Tonik\CLI\Scaffolding\FilesCloner;
use Tonik\CLI\Scaffolding\PackagesAdder;

abstract class Preset implements PresetInterface
{
    /**
     * Saffolding directory path.
     *
     * @var string
     */
    protected $dir;

    /**
     * Construct preset.
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
        $this->stubsDir = __DIR__ . '/stubs';
    }

    /**
     * Replaces project sass files with boilerplate's stubs.
     *
     * @param  string $stub
     * @return void
     */
    protected function updateSass($stub)
    {
        $source = "{$this->stubsDir}/{$stub}/sass";
        $desctination = "{$this->dir}/resources/assets/sass";

        (new FilesCloner($source))->clone($desctination);
    }

    /**
     * Replaces project javascripts files with boilerplate's stubs.
     *
     * @param  string $stub
     * @return void
     */
    protected function updateJavascript($stub)
    {
        $source = "{$this->stubsDir}/{$stub}/js";
        $desctination = "{$this->dir}/resources/assets/js";

        (new FilesCloner($source))->clone($desctination);
    }

    /**
     * Update the "package.json" file with additional dependencies.
     *
     * @return void
     */
    protected function updatePackages($dependencies)
    {
        (new PackagesAdder("{$this->dir}/package.json"))->add($dependencies);
    }

    /**
     * Update arguments of enqueue functions to new ones.
     *
     * @param  array $replacements
     * @return void
     */
    protected function updateAssets(array $replacements)
    {
        (new AssetsRenamer($this->dir))->replace($replacements);
    }
}
