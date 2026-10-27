<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with local demo data.
     */
    public function run(): void
    {
        // Never create a predictable demo account outside local/testing.
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $agent = User::updateOrCreate(
            ['phone' => '770000001'],
            [
                'name' => 'Agent de démonstration',
                'email' => null,
                'password' => 'AgentDemo2026!',
                'role' => 'agent',
            ],
        );

        // A demo agent should always have a wallet, without resetting its balance
        // if the seeder is run again.
        $agent->wallet()->firstOrCreate([], [
            'balance' => 0,
            'currency' => 'XOF',
        ]);
    }
}
