<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class BootstrapTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bootstrap');

        $this->assertFileContains('bootstrap-sass', "{$this->scaffoldingDir}/package.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bootstrap');

        $this->assertFileEquals("{$this->scaffoldingDir}/app/Http/assets.php", "{$this->stubsDir}/bootstrap/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stubsAssets = "{$this->stubsDir}/bootstrap/resources/assets";
        $scaffoldingAssets = "{$this->scaffoldingDir}/resources/assets";

        (new Scaffolder($this->scaffoldingDir))->build('bootstrap');

        $this->assertFileEquals("{$scaffoldingAssets}/sass/_variables.scss", "{$stubsAssets}/sass/_variables.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/_settings.scss", "{$stubsAssets}/sass/_settings.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/bootstrap.scss", "{$stubsAssets}/sass/bootstrap.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/app.scss", "{$stubsAssets}/sass/app.scss");

        $this->assertFileEquals("{$scaffoldingAssets}/js/bootstrap.js", "{$stubsAssets}/js/bootstrap.js");
        $this->assertFileEquals("{$scaffoldingAssets}/js/app.js", "{$stubsAssets}/js/app.js");
    }
}
