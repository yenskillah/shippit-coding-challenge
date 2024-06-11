<?php
use PHPUnit\Framework\TestCase;

use KingArthurFamily\AddChildProcessor;
use KingArthurFamily\GetRelationshipProcessor;
use KingArthurFamily\InitProcessor;
use KingArthurFamily\Processor;
use KingArthurFamily\Tree\Family;
use KingArthurFamily\Constants\SystemConstants;

class ProcessorTest extends TestCase
{
    private Family $family;
    protected function setUp(): void
    {
        $this->family = new Family();
    }

    /** @test */
    public function it_adds_a_child_successfully()
    {
        $processor = new AddChildProcessor();
        $this->family->setHeadOfTheFamily("Arthur", "Male");
        $this->family->setSpouse("Arthur", "Margret", "Female");

        $result = $processor->process($this->family, "ADD_CHILD Margret Bill Male");

        $this->assertEquals(SystemConstants::CHILD_ADDITION_SUCCESSFUL, $result);
    }

    /** @test */
    public function it_fails_to_add_a_child_when_mother_is_not_found()
    {
        $processor = new AddChildProcessor();
        $this->family->setHeadOfTheFamily("Arthur", "Male");

        $result = $processor->process($this->family, "ADD_CHILD Margret Bill Male");

        $this->assertEquals(SystemConstants::PERSON_NOT_FOUND, $result);
    }

    /** @test */
    public function it_finds_relationship_successfully()
    {
        $processor = new GetRelationshipProcessor();
        $this->family->setHeadOfTheFamily("Arthur", "Male");
        $this->family->setSpouse("Arthur", "Margret", "Female");
        $this->family->setChild("Margret", "Bill", "Male");
        $this->family->setChild("Margret", "Harry", "Male");

        $result = $processor->process($this->family, "GET_RELATIONSHIP Bill Siblings");

        $this->assertEquals("Harry", $result);
    }

    /** @test */
    public function it_initializes_family_correctly()
    {
        $processor = new InitProcessor();
        $commands = json_decode('{"command":"ADD_HEAD_OF_FAMILY","name":"King Arthur","gender":"Male"}', true);
        $result = $processor->process($this->family, $commands);

        $this->assertEquals("", $result);
        $this->assertEquals("King Arthur", $this->family->getHeadOfTheFamily()->getName());
    }

    /** @test */
    public function it_processes_file_with_init_commands()
    {
        $processor = new Processor();
        $testDatadir = __DIR__ . '/../data';
        chmod($testDatadir, 0755);

        $filePath = $testDatadir.'/test_init_commands.json';
        file_put_contents($filePath, '[{"command":"ADD_HEAD_OF_FAMILY","name":"King Arthur","gender":"Male"},{"command":"ADD_SPOUSE","person":"King Arthur","spouse":"Queen Margret","gender":"Female"}]');

        ob_start();
        $processor->processFile($this->family, $filePath, true);
        $output = ob_get_clean();

        $this->assertEmpty($output);
        $this->assertEquals("King Arthur", $this->family->getHeadOfTheFamily()->getName());
    }

    protected function tearDown(): void
    {
        unset($this->family);
    }
}