<?php

namespace App\Jobs;

use Faker\Factory as FakerFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use Illuminate\Support\Facades\Hash;

class FakeUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quantity;

    /**
     * FakeUsers constructor.
     *
     * @param int $quantity
     */
    public function __construct($quantity = 10)
    {
        $this->quantity = $quantity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usersData = [];
        $faker = FakerFactory::create();
        $i = 1;

        while ($i <= $this->quantity) {
            $random = $faker->lexify('????');
            $email = $random . '.' . $faker->freeEmail;
            $userData = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName . ' ' . $random,
                'email' => $email,
                'country_code' => 'US',
                'password' => '',
            ];
            $usersData[] = $userData;
            $i++;

        }

        User::insert($usersData);
    }
}
