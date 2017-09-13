<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class VueTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->scaffoldingDir))->build('vue');

        $this->assertFileContains('vue', "{$this->scaffoldingDir}/package.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->scaffoldingDir))->build('vue');

        $this->assertFileEquals("{$this->scaffoldingDir}/app/Http/assets.php", "{$this->stubsDir}/vue/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stubsAssets = "{$this->stubsDir}/vue/resources/assets";
        $scaffoldingAssets = "{$this->scaffoldingDir}/resources/assets";

        (new Scaffolder($this->scaffoldingDir))->build('vue');

        $this->assertFileEquals("{$scaffoldingAssets}/sass/_variables.scss", "{$stubsAssets}/sass/_variables.scss");
        $this->assertFileEquals("{$scaffoldingAssets}/sass/app.scss", "{$stubsAssets}/sass/app.scss");

        $this->assertFileEquals("{$scaffoldingAssets}/js/components/Example.vue", "{$stubsAssets}/js/components/Example.vue");
        $this->assertFileEquals("{$scaffoldingAssets}/js/app.js", "{$stubsAssets}/js/app.js");
    }
}
