<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // I use faker to generate random data
        $faker = Factory::create();

        // Fixures to generate 4 categories in database. 
        // I create an array with categories choosed by me and not generated by faker
        $carCategory = [
            'Berline',
            'SUV',
            'Cabriolet',
            'Monospace'
        ];

        
        // I create an empty array to store categories and reuse them in cars fixtures
        $carCategoryObject = [];

        // Foreach on categories array to create categories in database
        foreach ($carCategory as $currentCategory) {
            $carCategory = new CarCategory();
            $carCategory->setName($currentCategory);
            $carCategoryObject[] = $carCategory;
            $manager->persist($carCategory);
        }
        
        // Fixures to generate 30 cars on database
        $nbCars = 30;

        // for loop to create cars until $nbCars (30) is reached
        for ($i = 0; $i < $nbCars; $i++) {
            $car = new Car();
            $car->setNbDoors($faker->numberBetween(2, 5));
            $car->setNbSeats($faker->numberBetween(1, 5));
            $car->setName($faker->word());
            $car->setCost($faker->numberBetween(4000, 19000));
            $car->setCarCategory($faker->randomElement($carCategoryObject));
    
            $manager->persist($car);
           
        }

        $manager->flush();
    }
}
