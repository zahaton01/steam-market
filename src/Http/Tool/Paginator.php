<?php

namespace App\Http\Tool;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class Paginator
{
    /** @var PaginatorInterface  */
    private $paginator;

    /** @var Request */
    private $request;

    /**
     * PaginatorService constructor.
     * @param PaginatorInterface $paginator
     * @param RequestStack $request
     */
    public function __construct(PaginatorInterface $paginator, RequestStack $request)
    {
        $this->paginator = $paginator;
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @param Query $query
     * @return PaginationInterface
     */
    public function paginate(Query $query)
    {
        return $this->paginator->paginate(
            $query,
            $this->request->query->getInt('page', 1),
            $this->request->query->getInt('limit', 12)
        );
    }
}
