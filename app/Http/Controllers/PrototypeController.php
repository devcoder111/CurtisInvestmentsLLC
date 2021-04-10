<?php

namespace App\Http\Controllers;

use App\Flower;
use App\Jobs\FakeUsers;
use App\User;
use App\UserRef;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mavinoo\Batch\BatchFacade;

class PrototypeController extends Controller
{
    public $flower;

    public function __construct() {
        $flower = Flower::query()->first();
        /*
        if (!$flower) {
            $userRef = new UserRef();
            $userRef->save();

            $flower = new Flower(['root_user_ref_id' => $userRef->id]);
            $flower->save();
            $flower->refresh();
        }*/
        $this->flower = $flower;
    }

    public function index() {
        $allUsers = $this->flower->getUsers();
        $userRef = $this->flower->flowerRoot()->with('user')->get();

        $tree = $userRef->map(function($ref) {
            $tree = $ref->descendants()->with('user')->get()->toTree();
            return $ref->setRelation('children', $tree)->unsetRelation('descendants');
        });
        // $tree = [];

        return view('prototype.index', [
            'flower' => $this->flower,
            'tree' => addslashes(json_encode($tree)),
            'users' => $allUsers->pluck('user'),
            'all_users_qty' => User::query()->count(),
            'unassigned_user_qty' => User::query()->where('unassigned', '=', true)->count(),
        ]);
    }

    public function showUser($id) {
        $user = User::find($id);
        $userRefs = UserRef::query()->with('user')->withDepth()->where('user_id', '=', $user->id)->get();
        $userRef = $userRefs->last();
        if (!$userRef)  return;
        $depth = $userRef->depth;
        $week = $this->flower->current_week;

        if ($depth == $week - 1) $subflowerRoot = new Collection([$userRef]);
        else    $subflowerRoot = UserRef::withDepth()->with('user')->having('depth', '=', ($week - 1))->ancestorsOf($userRef->id);

        $tree = $subflowerRoot->map(function($ref) use ($week) {
            $tree = $ref->descendants()->with('user')->withDepth()->having('depth', '<', $week + 3)->get()->toTree();
            return $ref->setRelation('children', $tree)->unsetRelation('descendants');
        });

        return view('prototype.user', [
            'flower' => $this->flower,
            'tree' => addslashes($tree->toJson()),
            'user' => $user,
            'position' => User::readablePosition($week, $depth),
            /*'users' => $allUsers->pluck('user'),*/
            /*'unassigned_user_qty' => User::query()->where('unassigned', '=', true)->count(),*/
        ]);
    }

    public function createUsers() {
        $perDispatch = 10;
        $quantity = request()->has('qty') ? request()->get('qty') : 10;
        //$quantity = 100;

        $cycles = $quantity % 10;
        $rest = $quantity - ($perDispatch * $cycles);

        $i = 1;
        while ($i <= $cycles) {
            FakeUsers::dispatch($perDispatch);
        }

        if ($rest) {
            FakeUsers::dispatch($rest);
        }

        /*$quantity = request()->has('qty') ? request()->get('qty') : 10;
        $usersData = [];
        $faker = FakerFactory::create();
        $i = 1;

        while ($i <= $quantity) {
            $random = $faker->lexify('????');
            $email = $random . '.' . $faker->email;
            $userData = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName . ' ' . $random,
                'email' => $email,
                'country_code' => 'US',
                'password' => Hash::make($email),
            ];
            $usersData[] = $userData;
            $i++;
        }*/

        //Log::info('Inserting users');
        //$users = User::insert($usersData);
        //Log::info('Inserted users ' . $users);

        return redirect('prototype')->with('success', 'Users Generated');
    }

    public function assignUsers() {
        return $this->_assignUsers($this->flower->id);
    }

    public function _assignUsers($flowerId) {
        $flower = Flower::query()->find($flowerId);
        if (!$flower->current_week || $flower->current_week == 0)   $take = 15;
        else $take = 8 * pow(2, $flower->current_week);
        $assignableUsers = User::query()->where('unassigned', '=', true)->take($take)->get();
        $missingUsers = false;
        $count = 0;

        if ($this->flower->current_week) {
            $from = $this->flower->current_week;
            $to = $from + 2;
        } else {
            $from = 0;
            $to = 2;
            if ($assignableUsers->count() == 0) return null;
            $user = $assignableUsers->first();
            $userRef = $flower->flowerRoot()->withDepth()->having('depth', '=', $from)->first();
            if (!$userRef->user_id) {
                $userRef->user_id = $user->id;
                $userRef->save();
                $user->unassigned = false;
                $user->save();
                $assignableUsers = $assignableUsers->splice(1);
            }
        }

        $userUpdates = [];

        $i = $from;

        $waterRefs = null;
        $waterPay = 0;
        while ($i <= $to) {
            $count++;
            $userRefs = UserRef::withDepth()->having('depth', '=', $i)->get();
            $userRefsIndex = 0;
            $userRefs->each(function($userRef, $index) use (&$userRefsIndex, &$assignableUsers, $i, $to, $from, &$missingUsers, &$userUpdates, &$waterRefs, &$waterPay, $userRefs) {
                // Calculate missing children
                $childrenCount = $userRef->children->count();
                $missing = 2 - $childrenCount;
                $missingIndex = 0;

                if ($i == $from) {
                    $waterRefs = $userRefs;
                    // Add last week water, to the list of assignable users.
                    if ($i > 0) {
                        $previousWater = $userRef->parent->user;
                        if ($previousWater && !$assignableUsers->firstWhere('id', '=', $previousWater->id))  $assignableUsers->prepend($previousWater);
                    }
                }

                // If we are filling fires, Get the root (or userRef in water position) for payment
                /*if ($i == $to) {
                    $waterRef = $waterRef ? $waterRef : UserRef::withDepth()->having('depth', '=', $from)->ancestorsOf($userRef->id);
                    $waterRef = $waterRef[0];
                }*/
                // Fill with the missing children (this iterates 2 times max):
                while ($missingIndex < $missing) {
                    if ($assignableUsers->count() == 0) { $missingUsers = true; continue; }
                    $user = $assignableUsers->first();
                    $node = new UserRef(['user_id' => $user->id]);
                    $userRef->appendNode($node);
                    $userUpdate = ['id' => $user->id, 'unassigned' => 0];
                    if ($i == $to) {
                        $user->wallet = $user->wallet - $this->flower->enter_payment;
                        $waterPay += $this->flower->enter_payment;
                        $userUpdate['wallet'] = $user->wallet;
                        //$index = intdiv($userRefsIndex, pow(2,$to-2));
                        $currentIndex = 2 * $userRefsIndex + $missingIndex;
                        $index = intdiv($currentIndex, 8);
                        $waterUser = $waterRefs[$index]->user;
                        $waterUser->wallet += $this->flower->enter_payment;

                        // Update water wallet
                        //$userUpdates[] = ['id' => $waterRef->user->id, 'wallet' => $waterRef->user->wallet + $this->flower->enter_payment];
                        if (isset($waterRef) && $waterRef) {
                            //$rootUser = $waterRef->user;
                            //$rootUser->wallet += $this->flower->enter_payment;
                            //$rootUser->save();
                            //$userUpdates[] = ['id' => $rootUser->id, 'wallet' => $rootUser->wallet];
                        }
                        //$this->flower->accumulated_payments += $this->flower->enter_payment;
                        //$this->flower->save();
                    }
                    $userUpdates[] = $userUpdate;
                    //$user->save();
                    $assignableUsers = $assignableUsers->splice(1, $assignableUsers->count() - 1);
                    $missingIndex++;
                }

                /*if ($i == $to && $waterPay && $waterRefs) {
                    $waterRefs->count();
                    $index = intdiv($index, 4);
                    $waterUser = $waterRefs[$index]->user;
                    $userUpdates[] = ['id' => $waterUser->id, 'wallet' => $waterUser->wallet + $waterPay];
                    $waterPay = 0;
                }*/
                $userRefsIndex++;
            });
            $i++;

        }

        $waterRefs->each(function($waterRef) {
            $waterRef->user->save();
        });

        $userInstance = new User();
        BatchFacade::update($userInstance, $userUpdates, 'id');

        // If all missing users were added, we're ready to progress to next week
        if (!$missingUsers) {
            if (!$this->flower->current_week)   $this->flower->current_week = 1;
            else $this->flower->current_week++;
            $this->flower->save();
            // UserRefs in water position need to be set as unassigned
            $waterRefs = $flower->flowerRoot()->withDepth()->having('depth', '=', $from)->get();
            $waterRefs->each(function($waterRef) {
                $waterRef->user->unassigned = false;
                $waterRef->user->save();
            });
            return redirect('prototype')->with('success', 'Users assigned and Week advanced');
        } else {
            Log::emergency('Missing users when advancing week');
            return redirect('prototype')->with('success', 'Users assigned, but there are still missing users to complete flower and advance te Week.');
        }

    }

    public function resetDatabase() {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        return redirect('prototype')->with('success', 'Database Reset');
    }
}
