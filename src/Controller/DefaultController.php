<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(): Response
    {
        $res = $this->getCallApi();

        return $this->render('default/index.html.twig', [
            'response' => $res,
        ]);
    }

    public function getCallApi(): array
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.binance.com/api/v3/ticker/price");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);

        $newSgtring = substr($output, 1, -1);

        $stringToArray = explode('},', $newSgtring);
        $response = [];
        foreach ($stringToArray as $el) {
            array_push($response, json_decode($el . '}'));
        }

        curl_close($curl);

        return $response;
    }
}
