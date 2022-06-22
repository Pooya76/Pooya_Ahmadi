<?php

namespace App\Entity;

interface UserLogInterface
{
    public function setCreatedBy(User $createdBy);
    public function setUpdatedBy(User $updatedBy);
}