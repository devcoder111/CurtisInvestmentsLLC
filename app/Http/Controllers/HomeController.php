<?php

namespace App\Http\Controllers;

use App\Flower;
use App\Mail\ContactRequested;
use App\User;
use App\UserRef;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public $flower;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->flower = Flower::query()->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $memberState = 'fire'; // pre-fire, fire, air, earth, water
        $readableMemberState = 'Fire'; // Waiting, Fire, Air, Earth, Water
        $requiresPayment = true;
        return view('home', [
            'memberState' => $memberState,
            'requiresPayment' => $requiresPayment,
            'readableMemberState' => $readableMemberState,
        ]);
    }

    public function flower() {
        $user = Auth::user();

        return $this->flowerByUser($user->id);
    }

    public function flowerByUser($id) {
        $user = User::find($id);
        $userRefs = UserRef::query()->with('user')->withDepth()->where('user_id', '=', $user->id)->get();
        $userRef = $userRefs->last();
        if (!$userRef)  return abort(404);;
        $depth = $userRef->depth;
        $week = $this->flower->current_week;

        if ($depth == $week - 1) $subflowerRoot = new Collection([$userRef]);
        else    $subflowerRoot = UserRef::withDepth()->with('user')->having('depth', '=', ($week - 1))->ancestorsOf($userRef->id);

        $tree = $subflowerRoot->map(function($ref) use ($week) {
            $tree = $ref->descendants()->with('user')->withDepth()->having('depth', '<', $week + 3)->get()->toTree();
            return $ref->setRelation('children', $tree)->unsetRelation('descendants');
        });

        $memberState = 'fire'; // pre-fire, fire, air, earth, water
        $requiresPayment = false;

        return view('flower.index', [
            'flower' => $this->flower,
            'tree' => addslashes($tree->toJson()),
            'user' => $user,
            'position' => User::readablePosition($week, $depth),

            'memberState' => $memberState,
            'requiresPayment' => $requiresPayment,
        ]);
    }

    public function contact() {
        return view('contact.index');
    }

    public function processContact(Request $request) {

        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject'=>'required',
            'message' => 'required'
        ]);

        $data = $request->all();
        $recipients = explode(',', env('CONTACT_RECIPIENTS'));

        Mail::to($recipients)->send(new ContactRequested($data));

        return redirect()->route('contact')->with('success', 'Your messages has been sent.');;
    }

    public function landing() {

        return view('landing');
    }
}
