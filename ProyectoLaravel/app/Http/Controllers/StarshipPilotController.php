<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipPilotController extends Controller
{
    public function index()
    {
        $pilots = Pilot::all()->sortBy('name');
        $starships = Starship::all()->sortBy('name');

        $starship_pilot = DB::table('starship_pilot')
            ->join('starships', 'starship_pilot.starship_id', '=', 'starships.id')
            ->join('pilots', 'starship_pilot.pilot_id', '=', 'pilots.id')
            ->select('starship_pilot.id', 'starships.name as starship_name', 'pilots.name as pilot_name')
            ->get()
            ->groupBy('starship_name');

        return view('starshipPilot', ['starship_pilot' => $starship_pilot], compact('pilots', 'starships'));
    }

    public function destroyByName(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
    ]);

    $pilot = Pilot::where('name', $validated['name'])->first();

    if (!$pilot) {
        return redirect()->back()->with('error', 'Piloto no encontrado');
    }

    $pilot->starships()->detach();
    $pilot->delete();

    return $this->index()->with('success', 'Piloto eliminado correctamente');

}
    public function linkPilot(Request $request)
    {
        // Vincula un piloto a una nave en la base de datos utilizando la información proporcionada en $request
        $starshipId = $request->input('starship_id');
        $pilotId = $request->input('pilot_id');

        $starship = Starship::find($starshipId);
        $pilot = Pilot::find($pilotId);

        if ($starship && $pilot) {
            $starship->pilots()->attach($pilot);
            return $this->index()->with('success', 'Piloto vinculado correctamente');
        }

        return response()->json(['message' => 'Nave o piloto no encontrado.'], 404);
    }
}
