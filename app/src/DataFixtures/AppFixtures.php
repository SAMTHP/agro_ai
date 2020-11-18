<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\CityPlant;
use App\Entity\Climat;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Plant;
use App\Entity\Season;
use App\Entity\UserRole;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $userRoleAdmin = new UserRole();
        $userRoleAdmin->setTitle('ROLE_ADMIN');

        $manager->persist($userRoleAdmin);

        $user = new User();
        $user->setEmail("test@email.fr")
             ->addUserRole($userRoleAdmin)
             ->setLastName($faker->lastName())
             ->setFirstName($faker->firstName())
             ->setPassword($this->encoder->encodePassword($user,"test"));

        $manager->persist($user);

        $arrayPlant = ["Marijuana", "Carrotte de luxe", "Aubergine", "Pomme", "Poire", "Oignons", "Thym", "Poivrons", "Cerise", "Kiwi"];
        $arrayPlantObject = [];
        foreach ($arrayPlant as $plantName) {
            # code...
            $plant = new Plant();
            $plant->setName($plantName);
            $manager->persist($plant);
            array_push($arrayPlantObject, $plant);
        }

        $arrayClimat = [
            "tropical",
            "aride",
            "tempéré",
            "froid",
            "polaire",
            "tropicaux humides",
            "désertiques",
            "subtropicaux",
            "méditerranéen",
            "continental"
        ];

        $arrayCity = [
            "Nantes",
            "Bordeaux",
            "Perpignan",
            "Saugues",
            "Maubeuge",
            "Saint-Michel en grève",
            "La Braguette",
            "Saint-Jean du doigt",
            "Bourseul",
            "La Couyère",
            "Néant-sur-Yvel"
        ];


        $arrayCityObject = [];

        foreach ($arrayCity as $cityName) {
            $city = new City();
            $city->setLocalityName($cityName)
                 ->setPopulation(rand(2000,12000));
            
            array_push($arrayCityObject, $city);

            $manager->persist($city);
        }

        $arrayClimatObject = [];

        foreach ($arrayClimat as $labelClimat) {
            # code...
            $counter = rand(2, 8);
            $climat = new Climat();
            $climat->setLabel($labelClimat);
            array_push($arrayClimatObject, $climat);

            for($i = 0; $i < $counter; $i++){
                $climat->addPlant(
                    $arrayPlantObject[rand(0, count( $arrayPlantObject) - 1 )]
                );
                $manager->persist($plant);
            }

            $manager->persist($climat);
        }

        foreach($arrayCityObject as $city){
            $city->setClimat(
                $arrayClimatObject[rand(0, count( $arrayClimatObject) - 1 )]
            );

            $manager->persist($climat);
        }

        $arraySeason = [
            "hiver",
            "printemps",
            "été",
            "automne"
        ];

        $arraySeasonObject= [];

        foreach ($arraySeason as $seasonName) {
            $season = new Season();
            $season->setName($seasonName);
            array_push($arraySeasonObject, $season);
            $manager->persist($season);
        }

        for($year = 2010; $year <= 2020; $year++){
            $currentYear = new \DateTime("$year-12-30");
            foreach ($arraySeasonObject as $season) {
                foreach ($arrayCityObject as $city) {
                    foreach ($arrayPlantObject as $plant) {
                        $randomQuantitySold = rand(1.0, 5.0) * $city->getPopulation();
                        $randomQuantityProduced = rand($randomQuantitySold, $randomQuantitySold * 1.25);
                        $cityPlant = new CityPlant();
                        $cityPlant->setQuantityProducedInKg($randomQuantityProduced)
                                  ->setQuantitySoldInKg($randomQuantitySold)
                                  ->setSeason($season)
                                  ->setCity($city)
                                  ->setPlant($plant)
                                  ->setYear($currentYear);
                        
                        $manager->persist($cityPlant);
                    }
                }
            }
        }

        $manager->flush();
    }
}
