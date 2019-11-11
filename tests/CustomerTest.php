<?php
declare(strict_types=1);
include_once(__DIR__.'/../services/Database.php');

//het importeren van de Customer classe
// include "classes/Customer.php";

use PHPUnit\Framework\TestCase;

//Ik ben zelf nog niet echt goed in unit testen hierdoor kan het zijn
//dat hier en daar een paar foutjes zijn.
final class CustomerTest extends TestCase
{

    //Hier testen we als de methode LoadCar nog naar behoren werkt. 
    public function testLoadCustomer(): void {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('getAllRowsSafe')
            ->willReturn([['id' => 1,'first_name' => 'Jaap', 'last_name' => 'Jansen', 'age' => 24]]);

        $customer = new Customer();
        $customer->setDb($stubbedDatabase);
        $customer->loadCustomer(1);
       
        $this->assertSame(1,$customer->getId());
        $this->assertSame('Jaap',$customer->getFirstName());
        $this->assertSame('Jansen',$customer->getLastName());
        $this->assertSame(24,$customer->getAge());
    }
}
