<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Raid;

class RaidsController extends Controller
{
    /**
     * Get all or a specific raid from db
     *
     * @param int|null $id
     */
    public function show($id = null)
    {
        if ($id !== null) {
            $raid = $this->_getRaid($id);
        } else {
            $raid = $this->_getAllGyms();
        }
        
        return response()->json($raid);
    }
    
    /**
     * Get a specific gym
     *
     * @param int $id
     * @return \App\Raid
     */
    private function _getRaid($id)
    {
        return Raid::with(['trainers', 'gym', 'boss'])->find($id);
    }
    
    /**
     * Get all raids
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Raid[]
     */
    private function _getAllGyms()
    {
        return Raid::with(['trainers', 'gym', 'boss'])->get();
    }
    
    /**
     * Add a new raid
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        Raid::create($request->all());
        
        return redirect()->route('raids.get');
    }
    
    /**
     * Update a raid
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Raid::find($id)->update($request->all());
        
        return redirect()->route('raids.get');
    }
    
    /**
     * Add a trainer to a existing raid list
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addTrainerToRaid(Request $request, $id)
    {
        $raid = Raid::with(['trainers'])->find($id);
        $newTrainer = $request->all();
        $trainersId = [];
        foreach ($raid->trainers as $trainer) {
            $trainersId[] = $trainer->id;
        }
        if (!in_array($newTrainer['id'], $trainersId)) {
            $raid->trainers()->attach($newTrainer['id']);
        }
        
        return redirect()->route('raids.get', $id);
    }
}
