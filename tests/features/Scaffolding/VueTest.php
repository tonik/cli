<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class VueTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->destination))->build('vue');

        $this->assertFileContains('vue', "{$this->destination}/package.json");
        $this->assertFileContains('vue-loader', "{$this->destination}/package.json");
        $this->assertFileContains('vue-template-compiler', "{$this->destination}/package.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->destination))->build('vue');

        $this->assertFileEquals("{$this->destination}/app/Http/assets.php", "{$this->stubs}/vue/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stub = "{$this->stubs}/vue/resources/assets";
        $assets = "{$this->destination}/resources/assets";

        (new Scaffolder($this->destination))->build('vue');

        $this->assertFileEquals("{$assets}/js/components/Example.vue", "{$stub}/js/components/Example.vue");
        $this->assertFileEquals("{$assets}/js/app.js", "{$stub}/js/app.js");
    }
}
