<?php

namespace App\Controller;

use App\Core\Model\GetAverageScoreOfHotelRequest;
use App\Core\Service\GetAverageScoreOfHotel;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OvertimeController extends AbstractController
{
    public function __construct(private readonly GetAverageScoreOfHotel $getAverageScoreOfHotel, private readonly SerializerInterface $serializer)
    {
    }

    #[Route('overtime', name: "overtime_list", methods: "GET")]
    public function overtime(Request $request): Response
    {
        $getAverageScore = $this->getAverageScoreOfHotel;
        $response = $getAverageScore(new GetAverageScoreOfHotelRequest(
            $request->get('hotel-id'),
            DateTimeImmutable::createFromFormat("Y-m-d H:i", $request->get('start-date')),
            DateTimeImmutable::createFromFormat("Y-m-d H:i", $request->get('end-date')),
        ));
        return JsonResponse::fromJsonString($this->serializer->serialize($response, 'json'));
    }
}