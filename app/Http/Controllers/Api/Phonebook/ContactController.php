<?php

namespace App\Http\Controllers\Api\Phonebook;

use App\Actions\Contacts\ContactStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Phonebook API",
 *     description="API documentation for the Phonebook"
 * )
 * @OA\Tag(
 *     name="Contacts",
 *     description="API Endpoints for Contacts"
 * )
 */
class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/contacts",
     *     tags={"Contacts"},
     *     summary="Get list of contacts",
     *     description="Returns list of contacts",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))
     *     )
     * )
     */
    public function index()
    {
        return ContactResource::collection(Auth::user()->contacts);
    }

   /**
     * @OA\Post(
     *     path="/api/contacts",
     *     tags={"Contacts"},
     *     summary="Create a new contact",
     *     description="Creates a new contact",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created"
     *     )
     * )
     */
    public function store(ContactRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id(); 
        return ContactStoreAction::store($data);
    }

    /**
     * @OA\Get(
     *     path="/api/contacts/{contact_id}",
     *     tags={"Contacts"},
     *     summary="Get a specific contact",
     *     description="Returns a single contact",
     *     @OA\Parameter(
     *         name="contact_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function show(ContactRepositoryInterface $contactRepository, string $id)
    {
        return $contactRepository::showContactData($id);
    }

    /**
     * @OA\Put(
     *     path="/api/contacts/{contact_id}",
     *     tags={"Contacts"},
     *     summary="Update a specific contact",
     *     description="Updates a single contact",
     *     @OA\Parameter(
     *         name="contact_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact updated"
     *     )
     * )
     */
    public function update(ContactRequest $request, string $id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id(); 
        return ContactStoreAction::update($id, $data);
    }

    /**
     * @OA\Delete(
     *     path="/api/contacts/{contact_id}",
     *     tags={"Contacts"},
     *     summary="Delete a specific contact",
     *     description="Deletes a single contact",
     *     @OA\Parameter(
     *         name="contact_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact deleted"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return Contact::find($id)->delete();
    }
}
