<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function generateGameTurns(Request $request)
    {
        $numPlayers = $request->input('num_players', 3);
        $numTurns = $request->input('num_turns', 3);
        $startingPlayer = $request->input('starting_player', 'A');

        $players = range('A', chr(ord('A') + $numPlayers - 1));

        $gameTurns = [];

        $currentIndex = array_search($startingPlayer, $players);

        for ($turn = 0; $turn < $numTurns; $turn++) {
            $turnOrder = [];

            for ($i = 0; $i < $numPlayers; $i++) {
                $turnOrder[] = $players[($currentIndex + $i) % $numPlayers];
            }

            $gameTurns[] = $turnOrder;

            $firstPlayer = array_shift($players);
            array_push($players, $firstPlayer);

            if (($turn + 1) % $numPlayers == 0) {
                $players = array_reverse($players);
            }
        }


        return response()->json($gameTurns);
    }
}
