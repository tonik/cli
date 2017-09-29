<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class BootstrapTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->destination))->build('bootstrap');

        $this->assertFileContains('bootstrap-sass', "{$this->destination}/package.json");
    }

    public function test_updating_config()
    {
        (new Scaffolder($this->destination))->build('bootstrap');

        $this->assertFileContains('"bootstrap": [
            "./resources/assets/js/bootstrap.js",
            "./resources/assets/sass/bootstrap.scss"
        ]', "{$this->destination}/config/app.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->destination))->build('bootstrap');

        $this->assertFileEquals("{$this->destination}/app/Http/assets.php", "{$this->stubs}/bootstrap/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stub = "{$this->stubs}/bootstrap/resources/assets";
        $assets = "{$this->destination}/resources/assets";

        (new Scaffolder($this->destination))->build('bootstrap');

        $this->assertFileEquals("{$assets}/sass/_variables.scss", "{$stub}/sass/_variables.scss");
        $this->assertFileEquals("{$assets}/sass/_settings.scss", "{$stub}/sass/_settings.scss");
        $this->assertFileEquals("{$assets}/sass/bootstrap.scss", "{$stub}/sass/bootstrap.scss");
        $this->assertFileEquals("{$assets}/sass/app.scss", "{$stub}/sass/app.scss");

        $this->assertFileEquals("{$assets}/js/bootstrap.js", "{$stub}/js/bootstrap.js");
        $this->assertFileEquals("{$assets}/js/app.js", "{$stub}/js/app.js");
    }
}
