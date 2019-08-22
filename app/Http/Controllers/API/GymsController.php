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
    public function show(Request $request, $id = null)
    {
        if ($id !== null) {
            $gym = $this->_getGym($id);
        } else {
            $gym = $this->_getAllGyms($request);
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
    private function _getAllGyms($request)
    {
        if ($request->query('page')) {
            return Gym::paginate(10);
        } else {
            return Gym::all();
        }
    }
    
    /**
     * Search for a given gym name
     * 
     * @param Request $request
     * @return \App\Gym
     */
    public function search(Request $request)
    {
        $data = $request->all();
        return Gym::where('name', 'like', '%' . $data['name'] . '%')->paginate(10);
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
        
        return 'Ok';
//         return redirect()->route('raids.get');
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
        
        return 'Ok';
//         return redirect()->route('raids.get');
    }
}
