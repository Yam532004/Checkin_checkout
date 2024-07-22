<?php
namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Illuminate\Foundation\Auth\User as AuthUser;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  AuthUser $user
     * @param  array<string, string>  $input
     */
    public function update(AuthUser $user, array $input): void
    {
        Validator::make($input, [
            // 'password' => ['required', 'string', 'current_password:web'],
            'password' => [
                'required',
                'string',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(\W|_)).{5,}$/'
            ],
            'password_confirmation' => 'required|string|same:password', // Ensure confirmation matches
        ], [
            'password_confirmation.password_confirmation' => __('The provided password does not match your current password.'),
            'password.regex' => __('The password must be at least 5 characters long, and include at least one uppercase letter, one lowercase letter, one number, and one special character.'),
            'password_confirmation.same' => __('The password confirmation does not match.'),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}

