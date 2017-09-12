<?php

use League\CLImate\CLImate;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\CLI;
use Tonik\CLI\Command\Shake;
use Tonik\CLI\Renaming\Renamer;
use Tonik\CLI\Scaffolding\Scaffolder;

class BulmaTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->fixturesDir = dirname(__DIR__).'/../fixtures';
        $this->tempDir = "{$this->fixturesDir}/.temp";
        $this->stubsDir = dirname(__DIR__).'/../../src/CLI/Scaffolding/Presets/stubs';
        $this->scaffoldingDir = "{$this->fixturesDir}/scaffolding";

        $dir = escapeshellarg($this->scaffoldingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("cp -R $dir $temp");
    }

    protected function tearDown()
    {
        $dir = escapeshellarg($this->scaffoldingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("rm -rf $dir");
        exec("mv $temp $dir");
    }

    public function test_updating_packages()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertContains('bulma', file_get_contents("{$this->scaffoldingDir}/package.json"));
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertNotContains('vendor.css', file_get_contents("{$this->scaffoldingDir}/app/Http/assets.php"));
        $this->assertNotContains('vendor.js', file_get_contents("{$this->scaffoldingDir}/app/Http/assets.php"));

        $this->assertContains('bulma.css', file_get_contents("{$this->scaffoldingDir}/app/Http/assets.php"));
    }

    public function test_scaffolding_files()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertFileNotExists("{$this->scaffoldingDir}/resources/assets/sass/vendor.scss");
        $this->assertFileNotExists("{$this->scaffoldingDir}/resources/assets/js/vendor.js");

        $this->assertContains(
            file_get_contents("{$this->scaffoldingDir}/resources/assets/sass/_variables.scss"),
            file_get_contents("{$this->stubsDir}/bulma/sass/_variables.scss")
        );
        $this->assertContains(
            file_get_contents("{$this->scaffoldingDir}/resources/assets/sass/_settings.scss"),
            file_get_contents("{$this->stubsDir}/bulma/sass/_settings.scss")
        );
        $this->assertContains(
            file_get_contents("{$this->scaffoldingDir}/resources/assets/sass/bulma.scss"),
            file_get_contents("{$this->stubsDir}/bulma/sass/bulma.scss")
        );
        $this->assertContains(
            file_get_contents("{$this->scaffoldingDir}/resources/assets/sass/app.scss"),
            file_get_contents("{$this->stubsDir}/bulma/sass/app.scss")
        );
        $this->assertContains(
            file_get_contents("{$this->scaffoldingDir}/resources/assets/js/app.js"),
            file_get_contents("{$this->stubsDir}/bulma/js/app.js")
        );
    }
}
