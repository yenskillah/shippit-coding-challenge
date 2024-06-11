<?php

use KingArthurFamily\Constants\AttributeConstants;
use KingArthurFamily\Constants\OperationConstants;
use KingArthurFamily\Constants\RelationshipConstants;
use KingArthurFamily\Constants\SystemConstants;
use PHPUnit\Framework\TestCase;

class ConstantsTest extends TestCase
{
    /** @test */
    public function it_should_check_the_attributes_constants_values(): void
    {
        $this->assertEquals('Female',  AttributeConstants::FEMALE);
        $this->assertEquals('Male',  AttributeConstants::MALE);
        $this->assertEquals('NONE',  AttributeConstants::NONE);
    }

    /** @test */
    public function it_should_check_the_operations_constants_values(): void
    {
        $this->assertEquals('ADD_HEAD_OF_FAMILY',  OperationConstants::ADD_HEAD_OF_FAMILY);
        $this->assertEquals('ADD_CHILD',  OperationConstants::ADD_CHILD);
        $this->assertEquals('ADD_SPOUSE',  OperationConstants::ADD_SPOUSE);
        $this->assertEquals('GET_RELATIONSHIP',  OperationConstants::GET_RELATIONSHIP);
    }

    /** @test */
    public function it_should_check_the_relationship_constants_values(): void
    {
        $this->assertEquals('Paternal-Uncle',  RelationshipConstants::PATERNAL_UNCLE);
        $this->assertEquals('Maternal-Uncle',  RelationshipConstants::MATERNAL_UNCLE);
        $this->assertEquals('Paternal-Aunt',  RelationshipConstants::PATERNAL_AUNT);
        $this->assertEquals('Maternal-Aunt',  RelationshipConstants::MATERNAL_AUNT);
        $this->assertEquals('Sister-In-Law',  RelationshipConstants::SISTER_IN_LAW);
        $this->assertEquals('Brother-In-Law',  RelationshipConstants::BROTHER_IN_LAW);
        $this->assertEquals('Son',  RelationshipConstants::SON);
        $this->assertEquals('Daughter',  RelationshipConstants::DAUGHTER);
        $this->assertEquals('Siblings',  RelationshipConstants::SIBLINGS);
        $this->assertEquals(array(RelationshipConstants::SIBLINGS), RelationshipConstants::NO_GENDER_IDENTITY);
        $this->assertEquals(array_keys(
            array(RelationshipConstants::PATERNAL_AUNT => AttributeConstants::FEMALE, 
            RelationshipConstants::MATERNAL_AUNT  => AttributeConstants::FEMALE, 
            RelationshipConstants::SISTER_IN_LAW  => AttributeConstants::FEMALE, 
            RelationshipConstants::DAUGHTER => AttributeConstants::FEMALE,
            RelationshipConstants::PATERNAL_UNCLE => AttributeConstants::MALE,
            RelationshipConstants::MATERNAL_UNCLE => AttributeConstants::MALE,
            RelationshipConstants::BROTHER_IN_LAW => AttributeConstants::MALE,
            RelationshipConstants::SON => AttributeConstants::MALE)
        ), array_keys(RelationshipConstants::GENDER_IDENTITY));
    }

    /** @test */
    public function it_should_check_the_system_constants_values(): void
    {
        $this->assertEquals('INVALID_COMMAND',  SystemConstants::INVALID_COMMAND);
        $this->assertEquals('PERSON_NOT_FOUND',  SystemConstants::PERSON_NOT_FOUND);
        $this->assertEquals('RELATIONSHIP_MUST_NOT_BE_EMPTY',  SystemConstants::RELATIONSHIP_MUST_NOT_BE_EMPTY);
        $this->assertEquals('CHILD_ADDITION_FAILED',  SystemConstants::CHILD_ADDITION_FAILED);
        $this->assertEquals('CHILD_ADDED',  SystemConstants::CHILD_ADDITION_SUCCESSFUL);
        $this->assertEquals('data/family-tree.json',  SystemConstants::INIT_FILE);
    }
}
