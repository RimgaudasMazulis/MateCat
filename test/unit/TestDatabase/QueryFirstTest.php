<?php

/**
 * @group regression
 * @covers Database::query_first
 * User: dinies
 * Date: 13/04/16
 * Time: 15.18
 */
class QueryFirstTest extends AbstractTest
{

    protected $reflector;
    protected $property;
    /**
     * @var Database
     */
    protected $alfa_instance;
    protected $affected_rows;
    protected $sql_create;
    protected $sql_read;
    protected $sql_insert_first_value;
    protected $sql_insert_second_value;
    protected $sql_drop;
    public function setUp()
    {

        $this->reflectedClass = Database::obtain();
        $this->reflector = new ReflectionClass($this->reflectedClass);
        $this->property = $this->reflector->getProperty('instance');
        $this->reflectedClass->close();
        $this->property->setAccessible(true);
        $this->property->setValue($this->reflectedClass, null);
        $this->alfa_instance = $this->reflectedClass->obtain("localhost", "unt_matecat_user", "unt_matecat_user", "unittest_matecat_local");

        $this->sql_create = "CREATE TABLE Persons( PersonID INT )";
        $this->sql_drop="DROP TABLE Persons";
        $this->sql_insert_first_value = "INSERT INTO Persons VALUES (475144 )";
        $this->sql_insert_second_value = "INSERT INTO Persons VALUES (890788 )";

        $this->sql_read = "SELECT * FROM Persons";


        $this->alfa_instance->query($this->sql_create);
        $this->alfa_instance->query($this->sql_insert_first_value);
        $this->alfa_instance->query($this->sql_insert_second_value);

    }

    public function tearDown()
    {

        $this->alfa_instance->query($this->sql_drop);
        $this->reflectedClass = Database::obtain("localhost", "unt_matecat_user", "unt_matecat_user", "unittest_matecat_local");
        $this->reflectedClass->close();
        startConnection();
    }

    /**
     * This tests if the method query_first returns only the first value of the query.
     * @group regression
     * @covers Database::query_first
     * User: dinies
     */
    public function test_query_first_with_simple_table(){
        $this->assertEquals(array("PersonID" =>475144),$this->alfa_instance->query_first($this->sql_read));

    }
}