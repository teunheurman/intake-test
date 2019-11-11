<?php
declare(strict_types=1);
include_once(__DIR__.'/../services/Database.php');

//het importeren van de Customer classe
include "classes/Task.php";

use PHPUnit\Framework\TestCase;

//Ik ben zelf nog niet echt goed in unit testen hierdoor kan het zijn
//dat hier en daar een paar foutjes zijn.
final class TaskTest extends TestCase
{

    //Hier testen we als de methode LoadTask nog naar behoren werkt. 
    public function testLoadCar(): void {
        $stubbedDatabase = $this->createMock(Database::class);
        $stubbedDatabase->method('getAllRowsSafe')
            ->willReturn([['id' => 1,'car_id' => 3, 'task' => 'Olie vervangen', 'status' => 2]]);

        $task = new Task();
        $task->setDb($stubbedDatabase);
        $task->loadTask(1);
       
        $this->assertSame(1,$task->getId());
        $this->assertSame(3,$task->getCarId());
        $this->assertSame('Olie vervangen',$task->getTask());
        $this->assertSame(2,$task->getStatus());
    }
}
