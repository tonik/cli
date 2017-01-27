<?php

namespace Tonik\CLI\Shake;

use Mockery;
use TestCase;
use phpmock\phpunit\PHPMock;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Tonik\CLI\Shake\Renamer;

class RenamerTest extends TestCase
{
    use PHPMock;

    /**
     * @test
     */
    public function test_ignored_files_getter()
    {
        $finder = $this->getFinder();
        $renamer = $this->getRenamer($finder);

        $this->assertEquals($renamer->getIgnored(), [
            "node_modules",
            "vendor",
        ]);
    }

    /**
     * @test
     */
    public function test_renamer_init()
    {
        $finder = $this->getFinder();
        $file = $this->getFile();
        $renamer = $this->getRenamer($finder);

        $finder->shouldReceive('files')->andReturn($finder);
        $finder->shouldReceive('name')->with('*.php')->andReturn($finder);
        $finder->shouldReceive('name')->with('*.css')->andReturn($finder);
        $finder->shouldReceive('name')->with('*.json')->andReturn($finder);
        $finder->shouldReceive('exclude')->with($renamer->getIgnored())->andReturn($finder);
        $finder->shouldReceive('in')->with('dir/path')->andReturn([$file, $file]);

        $exists = $this->getFunctionMock(__NAMESPACE__, "file_put_contents");
        $exists->expects($this->any())->willReturn(true);

        $renamer->init('dir/path', ['mock' => 'answer']);
    }

    public function getFinder()
    {
        return Mockery::mock(Finder::class);
    }

    public function getFile()
    {
        $file = Mockery::mock(SplFileInfo::class);

        $file->shouldReceive('getExtension')->andReturn('php');
        $file->shouldReceive('getRealPath')->andReturn('file/path');
        $file->shouldReceive('getContents')->andReturn('{{mock}}');

        return $file;
    }

    public function getRenamer($finder)
    {
        return new Renamer($finder);
    }
}