<?php

namespace App\Vehicles\ground;


use App\Behaviours\ground\CarBehaviour;
use App\Fuels\FakeFuel;
use App\vehicles\Vehicle;

class FakeVehicleWithoutType extends Vehicle
{
    public function __construct($fuelAmount)
    {
        parent::__construct($fuelAmount);
        $this->behaviour = new CarBehaviour();
    }

    /**
     * @inheritdoc
     */
    public function getSuitableFuelTypes(): array
    {
        return [ FakeFuel::class ];
    }
}