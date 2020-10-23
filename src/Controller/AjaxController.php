<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index(RoleRepository $companyRepository, SerializerInterface $serializer): JsonResponse
    {
        $companies = $companyRepository->findAll();
        $data = $serializer->serialize($companies, JsonEncoder::FORMAT);
        return new JsonResponse($data, 200, [], true);
    }
}

?>
