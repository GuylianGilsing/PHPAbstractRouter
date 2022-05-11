<?php

declare(strict_types=1);

namespace GuylianGilsing\PHPAbstractRouter\HTTP\Facades\Routing;

final class RouteRegisterOrder
{
    private int $order = 0;

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $newOrder): void
    {
        $this->order = $newOrder;
    }

    public function add(int $amount): void
    {
        $this->order += $amount;
    }
}
