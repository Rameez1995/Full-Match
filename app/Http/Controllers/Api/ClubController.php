<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectCategory;
use App\Model\Videoclub;
use App\Model\Club;



class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public $successStatus = 200;
public $HTTP_FORBIDDEN = 403;
public $HTTP_NOT_FOUND = 404;


    public function clubs()
    {
     $clubs = Club::all();
     return response()->json(['success' => true, 'status' => $this->successStatus, 'message' => 'Club found.', 'data' => $clubs]);


    }


    public function club($id)
    {

     

        if (Videoclub::where('Club_id', $id)->exists()) {

            $video_club=Videoclub::select('videos.id','videos.video_title','videos.video_img')
            ->join('videos','videoclubs.Video_id' , '=' ,'videos.id')
            ->where('Club_id','=', $id)
            ->get();

        
     
         return response()->json(['success' => true, 'status' => $this->successStatus, 'message' => 'Club found.', 'data' => $video_club]);
          }
        else {
           return response()->json(['error' => false, 'status' => $this->HTTP_NOT_FOUND, 'message' => 'No record found.']);
         }
      

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $club=Club::find($id);
        return view('admin.club.edit',compact('club'));
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {



    }
}
