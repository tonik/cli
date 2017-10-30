<?php

use Tonik\CLI\CLI;
use Tonik\CLI\Renaming\Placeholders;
use Tonik\CLI\Scaffolding\Scaffolder;

class ExecutionTest extends PHPUnit_Framework_TestCase
{
    protected $answers = [
        '{{ theme.name }}' => 'Theme Name',
        '{{ theme.url }}' => 'Theme Website',
        '{{ theme.description }}' => 'Theme Description',
        '{{ theme.version }}' => 'Theme Version',
        '{{ theme.author }}' => 'Author',
        '{{ theme.author.url }}' => 'Author Website',
        '{{ theme.textdomain }}' => 'Theme Textdomain',
        'Tonik\Theme' => 'Theme\New\Name',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->climate = Mockery::mock('League\CLImate\CLImate');
        $this->input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');
        $this->cli = new CLI($this->climate);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function draw_a_banner()
    {
        $this->climate->shouldReceive('addArt')->once();
        $this->climate->shouldReceive('draw')->once()->with('tonik');
    }

    /**
     * @test
     */
    public function test_drawing_a_banner()
    {
        $this->draw_a_banner();

        $this->cli->drawBanner();
    }

    public function ask_for_replacements()
    {
        foreach ($this->cli->placeholders as $placeholder => $data) {
            $this->climate->shouldReceive('input')->once()->with($data['message'])->andReturn($this->input);
            $this->input->shouldReceive('defaultTo')->once()->with($data['value'])->andReturn($this->input);
            $this->input->shouldReceive('prompt')->once()->withNoArgs()->andReturn($this->answers[$placeholder]);
        }
    }

    /**
     * @test
     */
    public function test_asking_for_replacements()
    {
        $this->ask_for_replacements();

        $replacements = $this->cli->askForReplacements();

        foreach ($this->answers as $input => $value) {
            $this->assertEquals($value, $replacements[$input]);
        }
    }

    public function ask_for_preset($presetName)
    {
        $this->climate->shouldReceive('input')->once()->andReturn($this->input);
        $this->input->shouldReceive('accept')->once()->with($this->cli->presets, true)->andReturn($this->input);
        $this->input->shouldReceive('prompt')->once()->withNoArgs()->andReturn($presetName);
    }

    /**
     * @test
     */
    public function test_asking_for_preset()
    {
        $this->ask_for_preset('preset_name');

        $preset = $this->cli->askForPreset();

        $this->assertEquals('preset_name', $preset);
    }

    public function ask_for_a_scaffolding_confirmation_with_true_answer()
    {
        $this->climate->shouldReceive('confirm')->once()->andReturn($this->input);
        $this->input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(true);
    }

    public function ask_for_a_confirmation_with_true_answer()
    {
        $this->climate->shouldReceive('confirm')->once()->andReturn($this->input);
        $this->input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(true);
    }

    /**
     * @test
     */
    public function test_asking_for_a_confirmation_with_true_answer()
    {
        $this->ask_for_a_confirmation_with_true_answer();

        $this->assertTrue($this->cli->askForConfirmation());
    }

    public function ask_for_a_confirmation_with_false_answer()
    {
        $this->climate->shouldReceive('confirm')->once()->andReturn($this->input);
        $this->input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(false);
    }

    /**
     * @test
     */
    public function test_asking_for_a_confirmation_with_false_answer()
    {
        $this->ask_for_a_confirmation_with_false_answer();

        $this->assertFalse($this->cli->askForConfirmation());
    }

    /**
     * @test
     */
    public function test_proper_execution_run_with_preset()
    {
        $renamer = Mockery::mock('Tonik\CLI\Renaming\Renamer');
        $scaffolder = Mockery::mock('Tonik\CLI\Scaffolding\Scaffolder');

        $this->draw_a_banner();
        $this->ask_for_replacements();
        $this->ask_for_preset('preset_name');
        $this->ask_for_a_confirmation_with_true_answer();

        $this->climate->shouldReceive('backgroundLightGreen');

        $renamer->shouldReceive('replace')->once();
        $scaffolder->shouldReceive('build')->once();

        $this->cli->run($renamer, $scaffolder);
    }

    /**
     * @test
     */
    public function test_proper_execution_run_without_preset()
    {
        $renamer = Mockery::mock('Tonik\CLI\Renaming\Renamer');
        $scaffolder = Mockery::mock('Tonik\CLI\Scaffolding\Scaffolder');

        $this->draw_a_banner();
        $this->ask_for_replacements();
        $this->ask_for_preset('none');
        $this->ask_for_a_confirmation_with_true_answer();

        $this->climate->shouldReceive('backgroundLightGreen');

        $renamer->shouldReceive('replace')->once();
        $scaffolder->shouldReceive('build')->never();

        $this->cli->run($renamer, $scaffolder);
    }

    /**
     * @test
     */
    public function test_abored_execution_run()
    {
        $renamer = Mockery::mock('Tonik\CLI\Renaming\Renamer');
        $scaffolder = Mockery::mock('Tonik\CLI\Scaffolding\Scaffolder');

        $this->draw_a_banner();
        $this->ask_for_replacements();
        $this->ask_for_preset('preset_name');
        $this->ask_for_a_confirmation_with_false_answer();

        $this->climate->shouldReceive('backgroundRed');

        $renamer->shouldReceive('replace')->never();
        $scaffolder->shouldReceive('build')->never();

        $this->cli->run($renamer, $scaffolder);
    }
}
