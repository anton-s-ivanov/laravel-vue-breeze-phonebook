<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface ContactRepositoryInterface {
    public static function userContacts(User $user);
    public static function showContactData(int $id);
}