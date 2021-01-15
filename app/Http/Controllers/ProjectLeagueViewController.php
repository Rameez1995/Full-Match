<?php

namespace App\Http\Controllers;

use App\Model\club;
use App\Model\Slidervideo;
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
        $project = League::all();
            return view('admin.league.index', compact('project'));
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
         
         
        if ($request->file('filename1')==null)
        {

        $image3 = $request->file('filename3');
        $new_name3 = rand() . '.' . $image3->getClientOriginalExtension();
        $image3->move(public_path('app-assets/images/league'), $new_name3);

        $form_data1 = array(
             'league_name'     =>   $request->league_name,
             'league_promo_video'  =>   $request->filename2,
             'league_profile_image'  =>   $new_name3,
             'league_description'  =>   $request->league_description
        );

        // Insert League Array
        league::create($form_data1);

        // Id of Last Inserted League
        $id = DB::table('leagues')->orderBy('ID', 'DESC')->value('ID');

        //Insert Season Array
         
        foreach($request->addmore as $addmore){
            $newSeason = new Season();
            $newSeason->Project_id=$id;
            $newSeason->Seasons=$addmore['name'];
            $newSeason->Video = $addmore['qty'];
            $newSeason->save();
        }
      

       return redirect('league-form')->with('success', 'Data is successfully updated');
      }

      else if($request->file('filename1')!=null){
         $image1 = $request->file('filename1');
         $new_name1 = rand() . '.' . $image1->getClientOriginalExtension();
         $image1->move(public_path('app-assets/images/league'), $new_name1);

        $image3 = $request->file('filename3');
        $new_name3 = rand() . '.' . $image3->getClientOriginalExtension();
        $image3->move(public_path('app-assets/images/league'), $new_name3);

        $form_data1 = array(
             'league_name'     =>   $request->league_name,
             'league_promo_video'  =>   $request->filename2,
             'league_banner'  =>   $new_name1,
             'league_profile_image'  =>   $new_name3,
             'league_description'  =>   $request->league_description
        );

        // Insert League Array
        league::create($form_data1);

         // Id of Last Inserted League
          $id = DB::table('leagues')->orderBy('ID', 'DESC')->value('ID');

        //Insert Season Array
          
        foreach($request->addmore as $addmore){
            $newSeason = new Season();
            $newSeason->Project_id=$id;
            $newSeason->Seasons=$addmore['name'];
            $newSeason->Video = $addmore['qty'];
            $newSeason->save();
        }
      

      return redirect('league-form')->with('success', 'Data is successfully updated');

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


         $league=League::find($id);
         $season= Season::orderBy('id', 'ASC')->where('Project_id', $id)->get(); 
         
          return view('admin.league.edit',compact('league','season'));
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
           // dd($request->addmore);
        
        if($request->filename1!=null)
        {
            $image=$request->file('filename1');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('app-assets/images/league'), $new_name);

            $form_data2 = array(
                'league_banner'     =>   $new_name
            );

              League::whereId($id)->update($form_data2);
        }

        if($request->filename3!=null)
        {
            $image1=$request->file('filename3');
            $new_name1 = rand() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('app-assets/images/league'), $new_name1);

            $form_data2 = array(
                'league_profile_image'     =>   $new_name1
            );

              League::whereId($id)->update($form_data2);
        }

       
        $form_data = array(
            'league_name'       =>   $request->league_name,
            'league_description'       =>   $request->league_description,
            'league_sorting'       =>   $request->league_sorting,
            'league_promo_video'            =>   $request->league_promo_video
        );

        League::whereId($id)->update($form_data);

    
        Season::where('Project_id', $id)->forceDelete();
        
           foreach($request->addmore as $addmore){
               $newSeason = new Season();
               $newSeason->Project_id=$id;
               $newSeason->Seasons=$addmore['name'];
               $newSeason->Video = $addmore['qty'];
               $newSeason->save();
               }
           
               return redirect('league-form')->with('success', 'Data is successfully updated');

        


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
        $data3 = Season::all();
        $data4 = League::all();
        // $id = DB::table('seasons')->where('Project_id', $Cat_id)->value('id');
        return view('admin.season.index', compact('Image_id','data3','data4'));
       // return view('helloworld')->with('variableone', $id);

    }
}
