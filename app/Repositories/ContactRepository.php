<?php

namespace App\Repositories;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Inertia\Inertia;

class ContactRepository implements ContactRepositoryInterface {
    public static function userContacts(User $user) {
        return Inertia::render(
            'Phonebook/ContactsList', [
                'contactList' => $user->contacts
            ]
        );
    }
    public static function showContactData($id) {
        return Inertia::render(
            'Phonebook/OneContactPage', [
                'contactData' => new ContactResource(Contact::find($id))
            ]
        );
    }
}