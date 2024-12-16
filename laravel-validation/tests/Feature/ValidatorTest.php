<?php

namespace Tests\Feature;

use Closure;
use Tests\TestCase;
use App\Rules\UpperCase;
use App\Rules\RegistrationRule;
use Illuminate\Contracts\Validation\Validator as ContractsValidationValidator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\In;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator as ValidationValidator;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = [
            "username" => "Eko",
            "password" => "Rahasia"
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testErrorMessage()
    {
        $data = [
            "username" => "",
            "password" => ""
        ];
        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->fails());

        $result = $validator->getMessageBag()->toJson(JSON_PRETTY_PRINT);

        Log::info($result);
    }

    public function testValidationException()
    {
        $data = [
            "username" => "",
            "password" => ""
        ];
        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($data, $rules);

        try {
            $validator->validate();
            self::fail("Tidak Error");
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testMultipleRules()
    {
        $data = [
            "username" => "eko@gmail.com",
            "password" => "rhs"
        ];
        $rules = [
            "username" => ["required", "email", "max:10"],
            "password" => ["required", "min:5", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        try {
            $validator->validate();
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidData()
    {
        $data = [
            "username" => "ekogmail.com",
            "password" => "rahasia",
            "admin" => true,
            "other" => "xxxx"
        ];
        $rules = [
            "username" => ["required", "email", "max:20"],
            "password" => ["required", "min:5", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        try {
            $valid = $validator->validate();
            self::assertNotNull($valid);
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationCustom()
    {
        $data = [
            "username" => "eko",
            "password" => "rahasia",
        ];
        $rules = [
            "username" => ["required", "email", "max:20"],
            "password" => ["required", "min:5", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        try {
            $valid = $validator->validate();
            self::assertNotNull($valid);
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationCustomLocale()
    {
        App::setLocale("id");

        $data = [
            "username" => "eko",
            "password" => "rahasia",
        ];
        $rules = [
            "username" => ["required", "min:5"],
            "password" => ["required", "min:5", "max:100"]
        ];

        $validator = Validator::make($data, $rules);

        try {
            $valid = $validator->validate();
            self::assertNotNull($valid);
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationCustomInline()
    {
        $data = [
            "username" => "eko",
            "password" => "rahasia",
        ];
        $rules = [
            "username" => ["required", "min:5"],
            "password" => ["required", "min:5", "max:100"]
        ];
        $messages = [
            "min" => ":attribute harus minimal :min karakter"
        ];
        $validator = Validator::make($data, $rules, $messages);

        try {
            $valid = $validator->validate();
            self::assertNotNull($valid);
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testAdditionalValidation()
    {
        $data = [
            "username" => "admin@pzn.com",
            "password" => "admin@pzn.com"
        ];
        $rules = [
            "username" => ["required", "email"],
            "password" => ["required", "min:5"]
        ];

        $validator = Validator::make($data, $rules);
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            if ($data["username"] == $data["password"]) {
                $validator->errors()->add("password", "Password dan username tidak boleh sama");
            }
        });

        try {
            $validator->validate();
        } catch (ValidationException $validationException) {
            self::assertNotNull($validationException->validator);
            $message = $validationException->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testCustomRule()
    {
        $data = [
            "username" => "admin@pzn.com",
            "password" => "admin@pzn.com"
        ];
        $rules = [
            "username" => ["required", "email", new UpperCase()],
            "password" => ["required", "min:5", new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->fails());

        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }

    public function testCustomFunctionRule()
    {
        $data = [
            "username" => "admin@pzn.com",
            "password" => "admin@pzn.com"
        ];
        $rules = [
            "username" => ["required", "email", function (string $attributes, string $value, Closure $fail) {
                if ($value != strtoupper($value)) {
                    $fail("$attributes field with $value must be UpperCase");
                }
            }],
            "password" => ["required", "min:5", new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->fails());

        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }

    public function testRuleClass()
    {
        $data = [
            "username" => "khannedy",
            "password" => "rahasia"
        ];
        $rules = [
            "username" => ["required", new In(["eko", "budi", "joko"])],
            "password" => ["required", Password::min(5)->letters()->symbols()->numbers()]
        ];

        $validator = Validator::make($data, $rules);

        $result = $validator->fails();

        self::assertTrue($result);

        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }

    public function testNestedArray()
    {
        $data = [
            "name" => [
                "firstName" => "Eko",
                "lastName" => "Kurniawan"
            ]
        ];

        $rules = [
            "name.firstName" => ["required", "max:10", "min:5"],
            "name.lastName" => ["required", "max:10"],
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->fails());

        $result = $validator->errors()->toJson(JSON_PRETTY_PRINT);

        Log::info($result);
    }

    public function testIndexedArrayValidation()
    {
        $data = [
            "address" => [
                [
                    "country" => "indonesia",
                    "street" => "jalan kembar"
                ],
                [
                    "country" => "indonesia",
                    "street" => "jalan kembar"
                ]
            ]
        ];

        $rules = [
            "address.*.country" => ["required", "max:12", "min:10"],
            "address.*.street" => ["required", "max:10"],
        ];

        $validator = Validator::make($data, $rules);

        self::assertTrue($validator->fails());

        $result = $validator->errors()->toJson(JSON_PRETTY_PRINT);

        Log::info($result);
    }
}
