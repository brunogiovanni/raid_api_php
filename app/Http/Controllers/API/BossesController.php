<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Boss;

class BossesController extends Controller
{
    /**
     * Get all pokémon from PokeAPI
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFromAPI()
    {
        $maxPokemon = 9;
        $uri = 'https://pokeapi.co/api/v2/pokemon/';
        $pokemons = [];
        for ($i = 1; $i <= $maxPokemon; $i++) {
            $ch = curl_init($uri . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $pokemons[$i] = json_decode(curl_exec($ch));
        }
        
        $this->_save($pokemons);
    }
    
    /**
     * Save all pokémon from the PokeAPI
     * @param array $pokemons
     */
    private function _save(array $pokemons)
    {
        if (!empty($pokemons)) {
            foreach ($pokemons as $pokemon) {
                $boss = Boss::find($pokemon->id);
                if (empty($boss)) {
                    $boss = new Boss;
                }
                $boss->id = $pokemon->id;
                $boss->name = ucfirst($pokemon->name);
                $boss->imagem = $pokemon->sprites->front_default;
                $boss->cp = 0;
                $boss->in_raid = false;
                $boss->save();
            }
        }

        return redirect()->route('bosses.get');
    }

    /**
     * Display the specified resource.
     *
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        if ($id !== null) {
            $pokemon = $this->_getPokemon($id);
        } else {
            $pokemon = $this->_getAllPokemon($request);
        }
        
        return response()->json($pokemon);
    }
    
    /**
     * Get a specific pokemon
     * 
     * @param int $id
     * @return \App\Boss
     */
    private function _getPokemon($id)
    {
        return Boss::find($id);
    }
    
    public function search(Request $request)
    {
        $data = $request->all();
        return Boss::where('name', 'like', '%' . $data['name'] . '%')->paginate();
    }
    
    /**
     * Get all pokemon
     * @return \Illuminate\Database\Eloquent\Collection|\App\Boss[]
     */
    private function _getAllPokemon(Request $request)
    {
        if ($request->query('page')) {
            return Boss::paginate(3);
        } else {
            return Boss::all();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        Boss::find($id)->update($data);
        
        return 'Ok';
//         return redirect()->route('bosses.get');
    }
}
