<?php
namespace KingArthurFamily;

use KingArthurFamily\Constants\OperationConstants;
use KingArthurFamily\Constants\SystemConstants;
use KingArthurFamily\Interfaces\ProcessorInterface;
use KingArthurFamily\Tree\Family;
use \Exception;

class AddChildProcessor implements ProcessorInterface
{
    public function process(Family $family, string $command): string
    {
        $commandParts = explode(" ", $command);
        return $family->setChild($commandParts[1], $commandParts[2], $commandParts[3]);
    }
}

class GetRelationshipProcessor implements ProcessorInterface
{
    public function process(Family $family, string $command): string
    {
        $commandParts = explode(" ", $command);
        return $family->findRelationship($commandParts[1], $commandParts[2]);
    }
}

class InitProcessor implements ProcessorInterface
{
    public function process(Family $family, $command): string
    {
        switch ($command['command']) {
            case OperationConstants::ADD_HEAD_OF_FAMILY:
                $family->setHeadOfTheFamily($command['name'], $command['gender']);
                break;
            case OperationConstants::ADD_SPOUSE:
                $family->setSpouse($command['person'], $command['spouse'], $command['gender']);
                break;
            case OperationConstants::ADD_CHILD:
                $family->setChild($command['mother'], $command['child'], $command['gender']);
                break;
            default:
                return SystemConstants::INVALID_COMMAND;
        }
        return "";
    }
}

class Processor
{
    private array $Processors;
    public function __construct()
    {
        $this->Processors = [
            OperationConstants::ADD_CHILD => new AddChildProcessor(),
            OperationConstants::GET_RELATIONSHIP => new GetRelationshipProcessor(),
        ];
    }

    public function processFile(Family $family, string $filePath, bool $isInitFile): void
    {
        try {
            $fileInfo = pathinfo($filePath);

            if ($isInitFile) {
                if (strtolower($fileInfo['extension']) !== 'json') {
                    throw new Exception("File must have a .json extension!");
                }

                $jsonContent = file_get_contents($filePath);
                $commands = json_decode($jsonContent, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Invalid JSON file!");
                }

                foreach ($commands as $command) {
                    $processor = new InitProcessor();
                    $result = $processor->process($family, $command);
                    if ($result !== "") {
                        echo $result . PHP_EOL;
                    }
                }

            } else {

                if (strtolower($fileInfo['extension']) !== 'txt') {
                    throw new Exception("File must have a .txt extension!");
                }
    
                $lines = file($filePath, FILE_IGNORE_NEW_LINES);
                if(!$lines) {
                    throw new Exception("Error encountered when opening the file.");
                }

                foreach ($lines as $line) {
                    if ($line == "") {
                        continue;
                    }
        
                    $command = explode(" ", $line)[0];
                    $processor = $this->Processors[$command] ?? null;
                    
                    if ($processor !== null) {
                        $result = $processor->process($family, $line);
                        if ($result !== "") {
                            echo $result . PHP_EOL;
                        }
                    } else {
                        echo SystemConstants::INVALID_COMMAND . PHP_EOL;
                    }
                }
            }
        } catch (Exception $e) {
            echo "Failed on processing the file: " . $e->getMessage();
        }
    }
}
