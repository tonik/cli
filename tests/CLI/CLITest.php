<?php

use Tonik\CLI\CLI;

class CLITest extends PHPUnit_Framework_TestCase
{
    protected $inputs = [
        'Tonik Theme' => 'Theme Name',
        'https://github.com/tonik/tonik' => 'Theme Website',
        'Modern Starter Theme' => 'Theme Description',
        '2.0.0' => 'Theme Version',
        'Tonik' => 'Author',
        'http://tonik.pl' => 'Author Website',
        'tonik' => 'Theme Textdomain',
        'App\Theme' => 'Theme\New\Namespace',
    ];

    public function setUp()
    {
        $this->climate = Mockery::mock('League\CLImate\CLImate');
        $this->arguments = Mockery::mock('League\CLImate\Argument\Manager');

        $this->arguments->shouldReceive('add')->with([
            'help' => [
                'prefix' => 'h',
                'longPrefix' => 'help',
                'description' => 'Shake command help guide',
                'noValue' => true,
            ],
        ])->once();

        $this->climate->arguments = $this->arguments;
        $this->cli = new CLI($this->climate);
    }

    /**
     * @test
     */
    public function test_drawing_a_banner()
    {
        $this->climate->shouldReceive('addArt')->once();
        $this->climate->shouldReceive('draw')->once()->with('tonik');

        $this->cli->drawBanner();
    }

    /**
     * @test
     */
    public function test_asking_a_questions()
    {
        $input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');

        foreach ($this->cli->getQuestions() as $placeholder => $message) {
            $this->climate->shouldReceive('input')->once()->with($message)->andReturn($input);
            $input->shouldReceive('defaultTo')->once()->with($placeholder)->andReturn($input);
            $input->shouldReceive('prompt')->once()->withNoArgs()->andReturn($this->inputs[$placeholder]);
        }

        $this->cli->askQuestions();

        $this->assertEquals($this->inputs, $this->cli->getAnswers());
    }

    /**
     * @test
     */
    public function test_asking_for_a_confrimation()
    {
        $input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');

        $this->climate->shouldReceive('confirm')->once()->with('Continue?')->andReturn($input);

        $input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(true);
        $this->assertTrue($this->cli->askForConfirmation());

        $input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(false);
        $this->assertFalse($this->cli->askForConfirmation());
    }
}