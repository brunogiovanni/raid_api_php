<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gym;

class GymsController extends Controller
{
    /**
     * Get all or a specific gym from db
     *
     * @param int|null $id
     */
    public function show($id = null)
    {
        if ($id !== null) {
            $gym = $this->_getGym($id);
        } else {
            $gym = $this->_getAllGyms();
        }
        
        return response()->json($gym);
    }
    
    /**
     * Get a specific gym
     *
     * @param int $id
     * @return \App\Gym
     */
    private function _getGym($id)
    {
        return Gym::find($id);
    }
    
    /**
     * Get all gyms
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Gym[]
     */
    private function _getAllGyms()
    {
        return Gym::all();
    }
    
    /**
     * Add a new gym
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        Gym::create($request->all());
        
        return redirect()->route('raids.get');
    }
    
    /**
     * Update a gym
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Gym::find($id)->update($request->all());
        
        return redirect()->route('raids.get');
    }
}
