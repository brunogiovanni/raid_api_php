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
     * @param string|null $nickname
     */
    public function show($nickname = null)
    {
        if ($nickname !== null) {
            $trainer = $this->_getTrainer($nickname);
        } else {
            $trainer = $this->_getAllTrainers();
        }
        
        return response()->json($trainer);
    }
    
    /**
     * Get a specific trainer
     * 
     * @param string $nickname
     * @return \App\Trainer
     */
    private function _getTrainer($nickname)
    {
        return Trainer::all()->firstWhere('nickname', '=', $nickname);
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
     * @param string $nickname
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $nickname)
    {
        if (Trainer::all()->firstWhere('nickname', '=', $nickname)->update($request->all())) {
            return Trainer::all()->firstWhere('nickname', '=', $nickname);
        }
    }
}
