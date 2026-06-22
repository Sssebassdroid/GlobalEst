<?php

namespace App\DTOs;

use App\Http\Requests\RegisterRequest;

readonly class UserDTO
{
    public function __construct(
        public string $username,
        public string $name,
        public string $firstLastName,
        public ?string $secondLastName,
        public string $email,
        public string $password,
        public int $roleId
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            username: $request->validated('username'),
            name: $request->validated('name'),
            firstLastName: $request->validated('first_last_name'),
            secondLastName: $request->validated('second_last_name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            roleId: (int) $request->validated('role_id')
        );
    }
}
