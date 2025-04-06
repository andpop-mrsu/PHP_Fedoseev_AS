<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::all();
        return response()->json(['games' => $games]);
    }


    public function startGame(Request $request)
    {
        $playerName = $request->input('player_name');
        $start = rand(1, 50);
        $step = rand(2, 10);
        $length = 10;

        $progression = [];
        for ($i = 0; $i < $length; $i++) :
            $progression[] = $start + $i * $step;
        endfor;

        $hiddenIndex = rand(0, $length - 1);
        $correctAnswer = $progression[$hiddenIndex];

        $game = new Game();
        $game->player_name = $playerName;
        $game->progression = json_encode($progression);
        $game->missed_number = $correctAnswer;
        $game->game_date = now();
        $game->save();

        $progressionByPlayer = $progression;
        $progressionByPlayer[$hiddenIndex] = '...';

        return response()->json(['progression' => $progressionByPlayer, 'game_id' => $game->id]);
    }


    public function show(Game $game): JsonResponse
    {
        return response()->json(['game' => $game]);
    }

    public function checkGame(Request $request, Game $game)
    {
        $answered = $request->input('answered');
        if (!$game) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $status = $game->missed_number == $answered ? 'win' : 'lose';

        $game->result = $status;
        $game->player_answer = $answered;
        $game->save();

        return ['status' => $status];
    }

}
