<?php

namespace App\ArgumentResolver;

use App\Model\Query\QueryParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class QueryParamsResolver implements ArgumentValueResolverInterface
{
    /** @var string */
    private $dateFormat;

    public function __construct()
    {
        $this->dateFormat = 'd-m-Y';
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === QueryParams::class;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $queryParams = new QueryParams();

        try {
            if (!$request->query->has('start_date')) {
                throw new \Exception('start_date is missing');
            }

            $startDate = empty($request->query->get('start_date')) ?
                null : \DateTime::createFromFormat($this->dateFormat, $request->query->get('start_date'));
        } catch (\Exception $e) {
            $startDate = null;
        }

        try {
            if (!$request->query->has('end_date')) {
                throw new \Exception('end_date is missing');
            }

            $endDate = empty($request->query->get('end_date')) ?
                null : \DateTime::createFromFormat($this->dateFormat, $request->query->get('end_date'));
        } catch (\Exception $e) {
            $endDate = null;
        }

        $queryParams
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setFilters($request->get('filters'));

        yield $queryParams;
    }
}