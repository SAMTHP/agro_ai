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
use Doctrine\Common\Collections\ArrayCollection;
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

        $arrayPlant = ["Marie-Jeanne", "CBD", "Carotte de luxe", "Aubergine", "Pomme", "Poire", "Oignons", "Thym", "Poivrons", "Cerise", "Kiwi"];
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
            "tempéré",
            "froid",
            "méditerranéen",
            "littoral",
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
            "Paris",
            "Lyon",
            "Reims",
            "Rouen",
            "Toulouse",
            "Toulon",
            "Nice",
            "Nimes",
            "Brest",
            "Lille",
            "Annecy",
            "Prades",
            "Orlean",
            "Dijon",
            "Strasbourg",
            "Avignon",
            "Chartres",
            "Poitier",
            "Chambery",
            "Perigueux",
            "Néant-sur-Yvel"
        ];

        $arrayCityObject = [];
        foreach ($arrayCity as $cityName) {
            $city = new City();
            $city->setLocalityName($cityName)
                 ->setPopulation(rand(12000,120000));
            array_push($arrayCityObject, $city);
            $manager->persist($city);
        }
        // dd($arrayPlantObject);

        $arrayClimatObject = [];
        foreach ($arrayClimat as $labelClimat) {
            $counter = rand(1, 3);
            $climat = new Climat();
            $climat->setLabel($labelClimat);
            array_push($arrayClimatObject, $climat);
            for($i = 0; $i < $counter; $i++){
                $climat->addPlant(//check (itself) for no duplicity 
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
        
        $arraySeasonObject= [];
        $arraySeason = [
            "hiver",
            "printemps",
            "été",
            "automne"
        ];
        foreach ($arraySeason as $seasonName) {
            $season = new Season();
            $season->setName($seasonName);
            array_push($arraySeasonObject, $season);
            $manager->persist($season);
        }

    $arrayOfPopPerYearAndCity = [];
        
        for($year = 2010; $year <= 2020; $year++){
            $currentYear = new \DateTime("$year-01-01");
            
            foreach ($arraySeasonObject as $season) {
                foreach ($arrayCityObject as $city) {

                    $lastPop = isset($arrayOfPopPerYearAndCity[$city->getLocalityName()][$year-1]) ? $arrayOfPopPerYearAndCity[$city->getLocalityName()][$year-1] : $city->getPopulation();
                    $arrayOfPopPerYearAndCity[$city->getLocalityName()][$year] = $this->generateNewPopulation($lastPop);
                    // modifie légèrement la population d'une ville dans le temps
                    foreach ($arrayPlantObject as $plant) {

                        $climatModifier = $this->getClimatImpact(
                            $plant->getClimats(),
                            $city->getClimat()->getLabel()
                        );

                        $seasonModifier = $this->getSeasonImpact($season->getName());

                        $randomSold = $this->getRandomSold(
                            $arrayOfPopPerYearAndCity[$city->getLocalityName()][$year],
                            $climatModifier,
                            $seasonModifier
                        );

                        $isProducedMoreImportant = rand(1,10);
                        $randomProduced = $isProducedMoreImportant < 6 ? rand($randomSold, $randomSold * 1.33) : $randomSold;
                        $cityPlant = new CityPlant();
                        $cityPlant->setQuantityProducedInKg($randomProduced)
                                  ->setQuantitySoldInKg($randomSold)
                                  ->setSeason($season)
                                  ->setCity($city)
                                  ->setPlant($plant)
                                  ->setYear($currentYear)
                                  ->setPopulation($arrayOfPopPerYearAndCity[$city->getLocalityName()][$year]);
                        
                        $manager->persist($cityPlant);
                    }
                }
            }
        }

        $manager->flush();
    }

    /**
     * Modifie légèrement la population d'une ville dans le temps
     *
     * @param integer $population
     * @return integer new population
     */
    public function generateNewPopulation($population): int
    {
        $isNewPopMoreImportant = rand(1,10);
        $population = $isNewPopMoreImportant >= 5 ? $population * 1.15 : $population;
        $population = $isNewPopMoreImportant <= 2 ? $population / 1.10 : $population;
        return $population;
    }

    private function getRandomSold(int $population, float $climatModifier, float $seasonModifier): float
    {
        return rand(1.0, 3.0) * $population * $climatModifier * $seasonModifier;
    }

    private function getClimatImpact(ArrayCollection $climatPlants, string $climatCity): float
    {
        $climatModifier = 1.0;
        foreach ($climatPlants as $climatPlant) {
            // echo $climatModifier;
            $climatModifier = $climatPlant->getLabel() === $climatCity ? 1.30 : 1.0;
            // dd($climatModifier);
        }
        return $climatModifier; 
    }

    private function getSeasonImpact(string $season): float
    {          
        $seasonModifier = 1;
        $seasonModifier = $season === "hiver"? 1 : 2;
        $seasonModifier = $season === "été"? 3 : $seasonModifier;
        return $seasonModifier;
    }
}