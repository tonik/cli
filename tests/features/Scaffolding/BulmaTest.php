<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class BulmaTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->destination))->build('bulma');

        $this->assertFileContains('bulma', "{$this->destination}/package.json");
    }

    public function test_updating_config()
    {
        (new Scaffolder($this->destination))->build('bulma');

        $this->assertFileContains('"bulma": [
            "./resources/assets/sass/bulma.scss"
        ]', "{$this->destination}/config/app.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->destination))->build('bulma');

        $this->assertFileEquals("{$this->destination}/app/Http/assets.php", "{$this->stubs}/bulma/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stub = "{$this->stubs}/bulma/resources/assets";
        $assets = "{$this->destination}/resources/assets";

        (new Scaffolder($this->destination))->build('bulma');

        $this->assertFileEquals("{$assets}/sass/_variables.scss", "{$stub}/sass/_variables.scss");
        $this->assertFileEquals("{$assets}/sass/_settings.scss", "{$stub}/sass/_settings.scss");
        $this->assertFileEquals("{$assets}/sass/bulma.scss", "{$stub}/sass/bulma.scss");
        $this->assertFileEquals("{$assets}/sass/app.scss", "{$stub}/sass/app.scss");

        $this->assertFileEquals("{$assets}/js/app.js", "{$stub}/js/app.js");
    }
}
