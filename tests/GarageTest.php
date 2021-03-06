<?php

namespace App\Tests;

use App\BasicTestCase;
use App\Drivers\DriverInterface;
use App\Fuels\basis\Fuel;
use App\GasStation\GasStation;
use App\GasStation\GasStationInterface;
use App\vehicles\Vehicle;
use PHPUnit\Framework\TestCase;

class GarageTest extends BasicTestCase
{

    public function testGarageCanLoadACar()
    {
        $gasStation = new \App\GasStation\GasStation();
        $garage = new \App\Garage($gasStation);

        $garage->loadCar(new \App\Vehicles\ground\Car(10));
        $garage->loadCar(new \App\vehicles\air\Plane(200));

        $this->assertCount(2, $garage->getVehicles());
    }

    public function testGarageCanConnectWithGasStation()
    {
        $gasStation = new \App\GasStation\GasStation();
        $garage = new \App\Garage($gasStation);

        $this->assertEquals($gasStation, $garage->getGasStation());
    }

    public function testRefuelFunctionality()
    {
        $this->expectOutputRegex('~--- Refuel Mockery~');
        $fakeGasStation = \Mockery::mock(GasStationInterface::class)
            ->shouldReceive('refuel')
            ->andReturn(10)
            ->once()
            ->getMock();

        $fakeVehicle = \Mockery::mock(Vehicle::class)
            ->shouldReceive('addFuel')
            ->withArgs([10])
            ->once()
            ->getMock();

        $garage = new \App\Garage($fakeGasStation);
        $garage->loadCar($fakeVehicle);

        $garage->refuelVehicles();
    }

    public function testOfVehiclesUsage()
    {
        $this->expectOutputRegex("~ |--- Drive Mockery_0_App_vehicles_Vehicle~");
        $fakeGasStation = \Mockery::mock(GasStationInterface::class)->makePartial();

        $fakeDriver = \Mockery::mock(DriverInterface::class);
        $fakeDriver->shouldReceive('startMove')->once();
        $fakeDriver->shouldReceive('doSomething')->once();
        $fakeDriver->shouldReceive('stopMove')->once();


        $fakeVehicle = \Mockery::mock(Vehicle::class)
            ->shouldReceive('getDriver')
            ->andReturn($fakeDriver->makePartial())
            ->times(3)
            ->getMock();

        $garage = new \App\Garage($fakeGasStation);
        $garage->loadCar($fakeVehicle);

        $garage->useVehicles();
    }
}