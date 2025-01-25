<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AddressResource;
use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressController extends Controller
{
    private function getContact($idContact)
    {
        $user = Auth::user();
        $contact = Contact::where("user_id", $user->id)
            ->find($idContact);
        if (!$contact) {
            throw new HttpResponseException(
                response(
                    [
                        "errors" => [
                            "message" => [
                                "not found"
                            ]
                        ]
                    ],
                    404
                )
            );
        }
        return $contact;
    }
    private function getAddress($idContact, $idAddress)
    {
        $contact = $this->getContact($idContact);
        $address = Address::where("contact_id", $contact->id)
            ->find($idAddress);
        if (!$address) {
            throw new HttpResponseException(
                response(
                    [
                        "errors" => [
                            "message" => [
                                "not found"
                            ]
                        ]
                    ],
                    404
                )
            );
        }
        return $address;
    }

    public function create(int $idContact, CreateAddressRequest $request)
    {
        $contact = $this->getContact($idContact);
        $data = $request->validated();
        $address = new Address($data);
        $address->contact_id = $contact->id;
        $address->save();

        return (new AddressResource($address))
            ->response()
            ->setStatusCode(201);
    }

    public function get(int $idContact, int $idAddress)
    {
        $contact = $this->getContact($idContact);
        $address = $this->getAddress($contact->id, $idAddress);
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, int $idContact, int $idAddress)
    {
        $contact = $this->getContact($idContact);
        $address = $this->getAddress($contact->id, $idAddress);

        $data = $request->validated();
        $newAddress = $address->fill($data);
        $newAddress->contact_id = $contact->id;
        $newAddress->save();

        return new AddressResource($newAddress);
    }

    public function delete($idContacts, $idAddress)
    {
        $contact = $this->getContact($idContacts);
        $address = $this->getAddress($contact->id, $idAddress);
        $address->delete();
        return response()->json(["data" => true]);
    }

    public function list($idContact)
    {
        $contact = $this->getContact($idContact);
        $address = Address::where("contact_id", $contact->id)
            ->get();
        return AddressResource::collection($address);
    }
}
