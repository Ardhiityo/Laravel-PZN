<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ContactCollection;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function create(CreateContactRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = Auth::user();
        $contact = new Contact($data);
        $contact->user_id = $user->id;
        $contact->save();

        return (new ContactResource($contact))
            ->response()->setStatusCode(201);
    }

    public function get(int $id)
    {
        $user = Auth::user();

        $contact = Contact::where("id", $id)
            ->where("user_id", $user->id)
            ->first();

        if (!$contact) {
            return response(
                [
                    "errors" => [
                        "message" => [
                            "not found"
                        ]
                    ]
                ],
                404
            );
        }

        return new ContactResource($contact);
    }

    public function update(int $id, UpdateContactRequest $request)
    {
        $user = Auth::user();

        $contact = Contact::where("id", $id)
            ->where("user_id", $user->id)
            ->first();

        if (!$contact) {
            return response(
                [
                    "errors" => [
                        "message" => [
                            "not found"
                        ]
                    ]
                ],
                404
            );
        }

        $data = $request->validated();

        $contact->fill($data);
        $contact->save();

        return new ContactResource($contact);
    }

    public function delete(int $id)
    {
        $user = Auth::user();

        $contact = Contact::where("id", $id)
            ->where("user_id", $user->id)
            ->first();

        if (!$contact) {
            return response(
                [
                    "errors" => [
                        "message" => [
                            "not found"
                        ]
                    ]
                ],
                404
            );
        }

        $contact->delete();
        return response([
            "data" => true
        ], 200);
    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $contact = Contact::where("user_id", $user->id);

        $name = $request->query("name");

        if ($name) {
            $contact
                ->where("firstname", "like", "%$name%")
                ->orWhere("lastname", "like", "%$name%");
        }

        $phone = $request->query("phone");

        if ($phone) {
            $contact->where("phone", $phone);
        }

        $email = $request->query("email", false);
        if ($email) {
            $contact->where("email", $email);
        }

        $size = $request->query("size", 10);
        $page = $request->query("page", 1);

        $contact = $contact->paginate(perPage: $size, page: $page);

        return new ContactCollection($contact);
    }
}
