<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\League;
use DB;
use App\Model\Season;

class ProjectLeagueViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = League::latest()->paginate(5);
            return view('admin.league.index', compact('project'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.league.form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
         $request->validate([
            'league_name'     => 'required',
            'filename1'     => 'required',
            'filename2'     => 'required',
            'filename3'         =>  'required',
            'league_description'    => 'required'
        ]);

        //filename1 insertion
        $image1 = $request->file('filename1');
        $new_name1 = rand() . '.' . $image1->getClientOriginalExtension();
        $image1->move(public_path('images'), $new_name1);

        $image2 = $request->file('filename2');
        $new_name2 = rand() . '.' . $image2->getClientOriginalExtension();
        $image2->move(public_path('images'), $new_name2);

        $image3 = $request->file('filename3');
        $new_name3 = rand() . '.' . $image3->getClientOriginalExtension();
        $image3->move(public_path('images'), $new_name3);

        $form_data1 = array(
             'league_name'     =>   $request->league_name,
             'league_banner'  =>   $new_name1,
             'league_promo_video'  =>   $new_name2,
             'league_profile_image'  =>   $new_name3,
             'league_description'  =>   $request->league_description
        );

        // Insert League Array
        league::create($form_data1);
        
        // Id of Last Inserted League
        $id = DB::table('leagues')->orderBy('ID', 'DESC')->value('ID');

        $season_name="season";
        
        //Insert Season Array
        foreach($request->seasons as $season){
            $newSeason = new Season();
            $newSeason->Project_id=$id;
            $newSeason->Seasons=$season_name;
            $newSeason->Video = $season;
            $newSeason->save();
        }
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Season::where('Project_id', $id)->delete();

        $data = League::findOrFail($id);
        $data->delete();
        return redirect('league-form')->with('success', 'Data is successfully deleted');
    }

    public function destroy1($id)
    {
      //  $data = ProjectCategory::findOrFail($id);
      //  $data->delete();
        $Image_id=$id;
        $data3 = Season::latest()->paginate(5);
        $data4 = League::all();
        // $id = DB::table('seasons')->where('Project_id', $Cat_id)->value('id');
        return view('admin.season.index', compact('Image_id','data3','data4'));
       // return view('helloworld')->with('variableone', $id);

    }
}
