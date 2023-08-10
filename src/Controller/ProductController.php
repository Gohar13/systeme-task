<?php

declare(strict_types=1);

namespace App\Controller;

use App\Bundle\ApiBundle\Request\Model\CalculateProductPriceData;
use App\Form\CalculateProductPriceFormType;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\CountryService;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations\RequestBody;
use Throwable;

/**
 * @Route("/api/v1/product")
 */
class ProductController extends ApiController
{

    private ProductRepository $productRepository;
    private CouponRepository $couponRepository;
    private ProductService $productService;
    private CountryService $countryService;

    /**
     * @param SerializerInterface $serializer
     * @param ProductRepository $productRepository
     * @param CouponRepository $couponRepository
     * @param ProductService $productService
     * @param CountryService $countryService
     */
    public function __construct(
        SerializerInterface $serializer,
        ProductRepository $productRepository,
        CouponRepository $couponRepository,
        ProductService $productService,
        CountryService $countryService
    )
    {
        parent::__construct($serializer);

        $this->productRepository    = $productRepository;
        $this->couponRepository     = $couponRepository;
        $this->productService       = $productService;
        $this->countryService       = $countryService;
    }

    /**
     * Product
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/calculatePrice", name="calculate_price", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Order"},
     *     @OA\RequestBody(@Model(type=CalculateProductPriceFormType::class, groups={"create"})),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\Schema(
     *             properties={
     *                 @OA\Property(
     *                     property="calculatedPrice",
     *                     type="float"
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function CalculatePriceAction(Request $request): Response
    {
        try {

            $form = $this->processForm($request, CalculateProductPriceFormType::class);

            $formData = $form->getData();

            $calculationData = new CalculateProductPriceData(
                $formData['product'],
                $formData['taxNumber'],
                $formData['couponCode']
            );

            return $this->successResponse(
                [
                    'calculatedPrice' => $this->getNormalizedData(
                        $this->productService->calculateTotalPrice(
                            $this->productRepository->getByIdOrThrowIfMissing($calculationData->getProductId()),
                            $this->countryService->getCountryByTaxNumber($calculationData->getTaxNumber()),
                            $this->couponRepository->getByCodeOrThrowIfUsed($calculationData->getCouponCode()),
                        )
                    )
                ]
            );

        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

}