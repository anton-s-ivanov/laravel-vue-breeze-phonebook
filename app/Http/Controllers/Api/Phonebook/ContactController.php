<?php

namespace App\Http\Controllers\Api\Phonebook;

use App\Actions\Contacts\ContactStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection(Auth::user()->contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id(); 
        ContactStoreAction::store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactRepositoryInterface $contactRepository, string $id)
    {
        return $contactRepository::showContactData($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, string $id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id(); 
        ContactStoreAction::update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Contact::find($id)->delete();
    }
}
