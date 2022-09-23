<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= \Faker\Factory::create('fr_FR');
        
        for($i=0;$i<5;$i++){
            
            
            $event = new Event();
            $event->setDate($faker->dateTimeBetween($startdate = '-30years',
                    $endDate = 'now'))
                    ->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true))
                    ->setPlace($faker->address)
                    ->setDescription($faker->paragraph($nbSentences = 2, $variableNbSentences = true));
                    
            $manager->persist($event);
        }
        $manager->flush();
    }
}
