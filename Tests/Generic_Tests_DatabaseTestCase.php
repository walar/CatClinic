<?php

abstract class Generic_Tests_DatabaseTestCase extends PHPUnit_Extensions_Database_TestCase
{
    // Pour éviter le message "Cannot truncate a table referenced in a foreign key constraint"
    // https://github.com/sebastianbergmann/dbunit/issues/37
    
    protected function getSetUpOperation() {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            \PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }

    final public function getConnection()
    {
        return $this->createDefaultDBConnection(Connexion::recupererInstance('test')->donneLien());
    }

    protected function getTearDownOperation() {
        return PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL();
    }
}