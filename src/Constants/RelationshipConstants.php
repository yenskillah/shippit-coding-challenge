<?php
namespace KingArthurFamily\Constants;

use KingArthurFamily\Constants\AttributeConstants;
class RelationshipConstants {
    const PATERNAL_UNCLE = "Paternal-Uncle";
    const MATERNAL_UNCLE = "Maternal-Uncle";
    const PATERNAL_AUNT = "Paternal-Aunt";
    const MATERNAL_AUNT = "Maternal-Aunt";
    const SISTER_IN_LAW = "Sister-In-Law";
    const BROTHER_IN_LAW = "Brother-In-Law";
    const SON = "Son";
    const DAUGHTER = "Daughter";
    const SIBLINGS = "Siblings";


    const GENDER_IDENTITY = array(
        self::PATERNAL_AUNT => AttributeConstants::FEMALE, 
        self::MATERNAL_AUNT  => AttributeConstants::FEMALE, 
        self::SISTER_IN_LAW  => AttributeConstants::FEMALE, 
        self::DAUGHTER => AttributeConstants::FEMALE,
        self::PATERNAL_UNCLE => AttributeConstants::MALE,
        self::MATERNAL_UNCLE => AttributeConstants::MALE,
        self::BROTHER_IN_LAW => AttributeConstants::MALE,
        self::SON => AttributeConstants::MALE,
    );

    const NO_GENDER_IDENTITY = [self::SIBLINGS];
}


