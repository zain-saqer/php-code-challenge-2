<?php

namespace App\Core\Model;

interface HotelRepositoryInterface
{
    /**
     * @throws HotelNotFoundException
     */
    public function get(int $id): Hotel;
}