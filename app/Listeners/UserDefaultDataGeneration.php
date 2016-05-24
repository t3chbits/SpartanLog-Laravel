<?php

namespace App\Listeners;

use Auth;
use App\Exercise;
use App\Workout;
use App\Group;
use App\Events\UserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDefaultDataGeneration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        // Create several exercises, workouts, and groups,
        // and attach them to create any necessary relationships
        $benchPress = new Exercise([
            'name' => 'Barbell Bench Press',
            'bodyRegion' => 'Chest'
        ]);
        $event->user->exercises()->save($benchPress);

        $inclineBenchPress = new Exercise([
            'name' => 'Incline Barbell Bench Press',
            'bodyRegion' => 'Chest'
        ]);
        $event->user->exercises()->save($inclineBenchPress);

        $barbellRows = new Exercise([
            'name' => 'Barbell Rows',
            'bodyRegion' => 'Back'
        ]);
        $event->user->exercises()->save($barbellRows);

        $weightedPullups = new Exercise([
            'name' => 'Weighted Pullups',
            'bodyRegion' => 'Back'
        ]);
        $event->user->exercises()->save($weightedPullups);

        $overheadPress = new Exercise([
            'name' => 'Overhead Press',
            'bodyRegion' => 'Shoulders'
        ]);
        $event->user->exercises()->save($overheadPress);

        $squats = new Exercise([
            'name' => 'Squats',
            'bodyRegion' => 'Legs'
        ]);
        $event->user->exercises()->save($squats);

        $deadlifts = new Exercise([
            'name' => 'Deadlifts',
            'bodyRegion' => 'Legs'
        ]);
        $event->user->exercises()->save($deadlifts);

        $mwfFullbody = new Group(['name' => 'MWF Fullbody']);
        $event->user->groups()->save($mwfFullbody);

        $pushPullLegs = new Group(['name' => 'Push Pull Legs']);
        $event->user->groups()->save($pushPullLegs);

        $varA = new Workout(['name' => 'Variation A']);
        $event->user->workouts()->save($varA);

        $varB = new Workout(['name' => 'Variation B']);
        $event->user->workouts()->save($varB);

        $push = new Workout(['name' => 'Push']);
        $event->user->workouts()->save($push);

        $pull = new Workout(['name' => 'Pull']);
        $event->user->workouts()->save($pull);

        $legs = new Workout(['name' => 'Legs']);
        $event->user->workouts()->save($legs);

        $varA->groups()->attach($mwfFullbody->id);
        $varB->groups()->attach($mwfFullbody->id);

        $push->groups()->attach($pushPullLegs->id);
        $pull->groups()->attach($pushPullLegs->id);
        $legs->groups()->attach($pushPullLegs->id);

        $varA->exercises()->attach($benchPress->id);
        $varA->exercises()->attach($overheadPress->id);
        $varA->exercises()->attach($barbellRows->id);
        $varA->exercises()->attach($squats->id);

        $varB->exercises()->attach($inclineBenchPress->id);
        $varB->exercises()->attach($overheadPress->id);
        $varB->exercises()->attach($weightedPullups->id);
        $varB->exercises()->attach($deadlifts->id);

        $push->exercises()->attach($benchPress->id);
        $push->exercises()->attach($inclineBenchPress->id);
        $push->exercises()->attach($overheadPress->id);

        $pull->exercises()->attach($barbellRows->id);
        $pull->exercises()->attach($weightedPullups->id);

        $legs->exercises()->attach($squats->id);
        $legs->exercises()->attach($deadlifts->id);
    }
}
