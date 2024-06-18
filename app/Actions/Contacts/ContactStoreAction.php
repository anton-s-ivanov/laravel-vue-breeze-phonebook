<?php

namespace App\Actions\Contacts;

use App\Models\Contact;

class ContactStoreAction {
    public static function store ($data) {
        return Contact::create($data);
    }

    public static function update ($id, $data) {
        return Contact::find($id)->update($data);
    }
}

