<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Raid;
use App\Trainer;

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
            $raid = $this->_getAllRaids();
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
    private function _getAllRaids()
    {
        return Raid::where('dataHora', '>=', date('Y-m-d H:i'))->with(['trainers', 'gym', 'boss'])->paginate(10);
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
     * @param int $id Raid id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addTrainerToRaid(Request $request, $id)
    {
        $newTrainer = $request->all();
        $trainer = Trainer::all()->firstWhere('nickname', '=', $newTrainer['nickname']);
        $raid = Raid::with(['trainers'])->find($id);
        $trainersId = [];
        foreach ($raid->trainers as $trainerList) {
            $trainersId[] = $trainerList->nickname;
        }
        if (!in_array($newTrainer['nickname'], $trainersId)) {
            $raid->trainers()->attach($trainer);
        }
        
        return $this->_getRaid($id);
    }

    /**
     * Remove a trainer to a existing raid list
     * 
     * @param Request $request
     * @param int $id Raid id
     * @param string $nickname
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeTrainerFromList(Request $request, $id, $nickname)
    {
        // $trainer = Trainer::all()->firstWhere('nickname', '=', $fromBody['nickname']);
        $list = Raid::with(['trainers'])->find($id);
        foreach ($list->trainers as $trainerList) {
            if ($trainerList->nickname === $nickname) {
                $list->trainers()->detach($trainerList->id);
            }
        }

        return $this->_getRaid($id);
    }
}
