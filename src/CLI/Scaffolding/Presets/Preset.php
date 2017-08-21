<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\Renaming\Replacer;

abstract class Preset implements PresetInterface
{
    protected $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    protected function updateSass()
    {
        $this->mirror("{$this->stubDir(static::$name)}/sass", $this->sassDir());
    }

    protected function updateJavascript()
    {
        $this->mirror("{$this->stubDir(static::$name)}/js", $this->javascriptDir());
    }

    /**
     * Update the "package.json" file.
     *
     * @return void
     */
    protected function updatePackages()
    {
        if (! file_exists("{$this->dir}/package.json")) {
            return;
        }

        $packages = json_decode(file_get_contents("{$this->dir}/package.json"), true);

        $packages['dependencies'] = $this->packages($packages['dependencies']);

        ksort($packages['dependencies']);

        file_put_contents(
            "{$this->dir}/package.json",
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected function updateAssets($replacements)
    {
        $files = (new Finder)->files()
            ->name("assets.php")
            ->in("{$this->dir}/app/Http");

        foreach ($files as $file) {
            (new Replacer($file))->swap($replacements);
        }
    }

    protected function mirror($source, $target)
    {
        $fs = new Filesystem;

        if (! $fs->exists($target)) {
            $fs->mkdir($target, 0755);
        }

        $fs->mirror($source, $target, null, [
            'override' => true,
            'delete' => true,
        ]);
    }


    public function stubsDir()
    {
        return __DIR__."/stubs";
    }

    public function stubDir($name)
    {
        return __DIR__."/stubs/{$name}";
    }

    public function javascriptDir()
    {
        return "{$this->dir}/resources/assets/js";
    }

    public function sassDir()
    {
        return "{$this->dir}/resources/assets/sass";
    }
}
