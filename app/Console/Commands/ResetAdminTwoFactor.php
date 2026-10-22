<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ResetAdminTwoFactor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:2fa-reset {email : Email of the admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Google Authenticator 2FA for a user (e.g. lost phone); they will set it up again on next login';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (!$user) {
            $this->error('User not found.');
            return self::FAILURE;
        }

        if (!$this->confirm("Reset 2FA for {$user->email}? All of their active sessions will be logged out.")) {
            return self::SUCCESS;
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
            'two_factor_last_used_step' => null,
            'remember_token' => null,
        ])->save();

        // Log out every session of this user (database session driver)
        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))->where('user_id', $user->id)->delete();
        }

        Log::warning('Admin 2FA: reset from console', ['user_id' => $user->id]);

        $this->info('2FA has been reset. The user will be asked to scan a new QR code on next login.');

        return self::SUCCESS;
    }
}
