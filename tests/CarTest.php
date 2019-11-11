<?php
declare(strict_types=1);
include_once(__DIR__.'/../services/Database.php');

//het importeren van de Customer classe
include "classes/Car.php";

use PHPUnit\Framework\TestCase;

//Ik ben zelf nog niet echt goed in unit testen hierdoor kan het zijn
//dat hier en daar een paar foutjes zijn.
final class CarTest extends TestCase
{
    //Ik moest deze stest methode iets aan passen omdat ik de call in car 
    //Ook had verandert, Hierbij geeft de server een array terug met het
    //object nr_of_tasks hier in staat hoeveel task deze auto heeft.
    public function testCarCanGetNumberOfTasks(): void
    {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('getAllRows')
            ->willReturn([['nr_of_tasks'=> 1]]);

        $car = new Car();

        $car->setDb($stubbedDatabase);
        $car->setCustomerId(1);

        $this->assertSame(1, $car->getNumberOfTasksOfCar());
    }


    //Hier testen we als de methode LoadCar nog naar behoren werkt. 
    public function testLoadCar(): void {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('getAllRowsSafe')
            ->willReturn([['id' => 1,'customer_id' => 1, 'brand' => 'Peugeot', 'type' => '206']]);

        $car = new Car();
        $car->setDb($stubbedDatabase);
        $car->loadCar(1);
       
        $this->assertSame(1,$car->getCustomerId());
        $this->assertSame('Peugeot',$car->getBrand());
        $this->assertSame('206',$car->getType());
    }

    //Hier testen we als de methode getCustomerOfCar nog naar behoren werkt. 
    public function testgetCustomerOfCar(): void {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('getAllRowsSafe')
            ->willReturn([['id' => 1,'customer_id' => 1, 'brand' => 'Peugeot', 'type' => '206']]);
           
        $car = new Car();

        $car->setDb($stubbedDatabase);   
        $car->loadCar(1);    

        $customer = $car->getCustomerOfCar();
    
        $this->assertSame(1,$customer->getId());
        $this->assertSame('Jaap',$customer->getFirstName());
        $this->assertSame('Jansen',$customer->getLastName());
        $this->assertSame(24,$customer->getAge());
    }

    
    public function testAddCar(): void {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('execQuerySafe');
        $stubbedDatabase->method('getAllRowsSafe')
            ->willReturn([['id' => 1,'customer_id' => 1, 'brand' => 'a', 'type' => 'b']]);

           
        $car = new Car();
        $car->setDb($stubbedDatabase);   
        $car->addCar(1,'a','b');
    
        $this->assertSame(1,$car->getCustomerId());
        $this->assertSame('a',$car->getBrand());
        $this->assertSame('b',$car->getType());
    }
}
