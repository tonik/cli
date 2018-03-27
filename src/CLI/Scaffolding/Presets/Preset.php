<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\Renaming\Replacer;
use Tonik\CLI\Scaffolding\AssetsRenamer;
use Tonik\CLI\Scaffolding\ConfigAdder;
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
        $source = "{$this->stubsDir}/{$stub}/resources/assets/sass";
        $destination = "{$this->dir}/resources/assets/sass";

        (new FilesCloner($source))->clone($destination);
    }

    /**
     * Replaces project javascripts files with boilerplate's stubs.
     *
     * @param  string $stub
     * @return void
     */
    protected function updateJavascript($stub)
    {
        $source = "{$this->stubsDir}/{$stub}/resources/assets/js";
        $destination = "{$this->dir}/resources/assets/js";

        (new FilesCloner($source))->clone($destination);
    }

    /**
     * Update arguments of enqueue functions to new ones.
     *
     * @param  array $replacements
     * @return void
     */
    protected function updateAssets($stub)
    {
        $source = "{$this->stubsDir}/{$stub}/app/Http/assets.php";
        $destination = "{$this->dir}/app/Http/assets.php";

        (new FilesCloner($source))->copy($destination);
    }

    /**
     * Update the "package.json" file with additional dependencies.
     *
     * @return void
     */
    protected function updateDependencies($packages)
    {
        (new PackagesAdder("{$this->dir}/package.json"))->addDependencies($packages);
    }

    /**
     * Update the "package.json" file with additional dependencies.
     *
     * @return void
     */
    protected function updateDevDependencies($packages)
    {
        (new PackagesAdder("{$this->dir}/package.json"))->addDevDependencies($packages);
    }

    /**
     * Update the "app.json" file with additional assets.
     *
     * @return void
     */
    protected function updateConfig($assets)
    {
        (new ConfigAdder("{$this->dir}/config/app.json"))->add($assets);
    }
}
