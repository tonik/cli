<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class ScaffoldingTest extends StubsCase
{
    /**
     * @test
     */
    public function it_should_throw_when_package_file_not_exists()
    {
        exec("rm $this->destination/package.json");

        $this->expectException(RuntimeException::class);

        (new Scaffolder($this->destination))->build('vue');
    }
}
