<?php
namespace Store\RestBundle\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * My custom datatype.
 */
class AJsonType extends Type
{
    const MONEY = 'ajson'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'array';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $t = $value;
       return  $t;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {

        return json_encode($value);
    }

    public function getName()
    {
        return self::MONEY;
    }
}