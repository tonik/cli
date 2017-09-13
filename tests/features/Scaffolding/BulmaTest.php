<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class BulmaTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertFileContains('bulma', "{$this->scaffoldingDir}/package.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertFileEquals("{$this->scaffoldingDir}/app/Http/assets.php", "{$this->stubsDir}/bulma/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stubsAssets = "{$this->stubsDir}/bulma/resources/assets";
        $scaffoldingAssets = "{$this->scaffoldingDir}/resources/assets";

        (new Scaffolder($this->scaffoldingDir))->build('bulma');

        $this->assertFileEquals("{$scaffoldingAssets}/sass/_variables.scss", "{$stubsAssets}/sass/_variables.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/_settings.scss", "{$stubsAssets}/sass/_settings.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/bulma.scss", "{$stubsAssets}/sass/bulma.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/app.scss", "{$stubsAssets}/sass/app.scss");

        $this->assertFileEquals("{$scaffoldingAssets}/js/app.js", "{$stubsAssets}/js/app.js");
    }
}
