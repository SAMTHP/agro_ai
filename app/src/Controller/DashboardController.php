<?php

namespace App\Controller;

use App\Entity\CityPlant;
use App\Repository\CityPlantRepository;
use App\Repository\CityRepository;
use App\Repository\PlantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * 
     * 
     * @return Response
     */
    public function index(PlantRepository $plantRepository, CityRepository $cityRepository, CityPlantRepository $cityPlantRepository, SerializerInterface $serializerInterface): Response
    {
        
        
        return $this->render('dashboard/index.html.twig', [
           
        ]);
    }

    /**
     * Undocumented function
     *
     * @Route("/get-city-plant-datas", name="get_city_plant_datas")
     * 
     * @param CityPlant $cityPlant
     * @return void
     */
    public function getCityPlantDatas(CityPlantRepository $cityPlantRepository,SerializerInterface $serializerInterface) : JsonResponse 
    {
        $datas = array_map(function (CityPlant $cityPlant) {
            return [
                "season" => $cityPlant->getSeason()->getName(),
                "city" => $cityPlant->getCity()->getLocalityName(),
                "cityPopulation" => $cityPlant->getCity()->getPopulation(),
                "plant" => $cityPlant->getPlant()->getName(),
                "year" => $cityPlant->getYear(),
                "quantitySold" => $cityPlant->getQuantitySold(),
                "quantityProduced" => $cityPlant->getQuantityProduced(),
            ];
        }, $cityPlantRepository->findAll());

        $results = $serializerInterface->serialize(
            $datas,
            'json',
            []
        );

        return new JsonResponse(
            $results,
            Response::HTTP_OK,
            [],
            true
        );
    }
}
