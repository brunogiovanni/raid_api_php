<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trainer;

class TrainersController extends Controller
{
    /**
     * Get all or a specific trainer from db
     * 
     * @param int|null $id
     */
    public function show($id = null)
    {
        if ($id !== null) {
            $trainer = $this->_getTrainer($id);
        } else {
            $trainer = $this->_getAllTrainers();
        }
        
        return response()->json($trainer);
    }
    
    /**
     * Get a specific trainer
     * 
     * @param int $id
     * @return \App\Trainer
     */
    private function _getTrainer($id)
    {
        return Trainer::find($id);
    }
    
    /**
     * Get all trainers
     * 
     * @return \Illuminate\Database\Eloquent\Collection|\App\Trainer[]
     */
    private function _getAllTrainers()
    {
        return Trainer::all();
    }
    
    /**
     * Add a new trainer to db
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        Trainer::create($request->all());
        
        return redirect()->route('raids.get');
    }
    
    /**
     * Update a trainer
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Trainer::find($id)->update($request->all());
        
        return redirect()->route('raids.get');
    }
}
