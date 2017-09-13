<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class FoundationTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->scaffoldingDir))->build('foundation');

        $this->assertFileContains('foundation-sites', "{$this->scaffoldingDir}/package.json");
        $this->assertFileContains('motion-ui', "{$this->scaffoldingDir}/package.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->scaffoldingDir))->build('foundation');

        $this->assertFileEquals("{$this->scaffoldingDir}/app/Http/assets.php", "{$this->stubsDir}/foundation/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stubsAssets = "{$this->stubsDir}/foundation/resources/assets";
        $scaffoldingAssets = "{$this->scaffoldingDir}/resources/assets";

        (new Scaffolder($this->scaffoldingDir))->build('foundation');

        $this->assertFileEquals("{$scaffoldingAssets}/sass/_variables.scss", "{$stubsAssets}/sass/_variables.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/_settings.scss", "{$stubsAssets}/sass/_settings.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/foundation.scss", "{$stubsAssets}/sass/foundation.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/app.scss", "{$stubsAssets}/sass/app.scss");

        $this->assertFileEquals("{$scaffoldingAssets}/js/foundation.js", "{$stubsAssets}/js/foundation.js");
        $this->assertFileEquals("{$scaffoldingAssets}/js/app.js", "{$stubsAssets}/js/app.js");
    }
}
