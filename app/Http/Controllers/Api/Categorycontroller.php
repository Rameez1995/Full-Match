<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Category_genre;
use App\Model\Video_genre;
use App\Model\Slider;
use App\Model\Slidervideo;
use App\Model\Video;
use App\Model\Adv_banner;
use App\Model\Adv_banner_video;
use App\Model\Club;
use App\Model\League;
use App\Model\Player;
use App\Model\Leaguecategory;
use App\Model\Videoclub;
use App\Model\Videogenre;
use App\Model\Videoplayer;
use DB;
use \stdClass;


class CategoryController extends Controller
{
    public $successStatus = 200;
    public $HTTP_FORBIDDEN = 403;
    public $HTTP_NOT_FOUND = 404;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gethomepageinfo()
    {
        $home_slider_array = array();
        $category_id=null;
        $slider_id = Slider::select("id")->where('category_id',$category_id)->get();
        $video_id=Slidervideo::select("Video_id")->wherein('Slider_id',$slider_id)->get();
        $videos=Video::wherein('id',$video_id)->get();

        foreach ($videos as $k => $v) {

            $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));

            $home_slider_array[$k]['id'] = $v->id;
            $home_slider_array[$k]['title'] = $v->title_en;
            $home_slider_array[$k]['title_ar'] = $v->title_ar;
            $home_slider_array[$k]['description'] = $v->description_en;
            $home_slider_array[$k]['description_ar'] = $v->description_ar;
            $home_slider_array[$k]['image'] = $video_img;

        }

        return response()->json(['success' => true, 'status' => $this->successStatus, 'message' => 'Home Slider Videos found.', 'data'=>  $home_slider_array]);


    }


    public function getcategoryinfo(request $request,$id)
    {
        $obj = new stdClass;

        $slider_array = array();
        $banner_array = array();
        $latest_videos_array = array();
        $club_array = array();
        $player_array = array();
        $league_array=array();

        $obj->homelayout = new stdClass;

        //getting slider id of that specific categories
        $slider_id = Slider::select("id")->where('category_id',$id)->first();

        //getting video id of banner_id of that specific category
        $banner_video_id = Adv_banner::select("id")->where('category_id',$id)
                    ->where('genre_id','=',0)
                    ->get();

        //getting genres id of that specific categories
        $genre_id = Videogenre::select("genre_id")->where('category_id',$id)->get();

        //getting videos id that are associated with that specific categories
        $videos_id = Video::select("id")->where('category_id',$id)->get();

        //getting videos id that are associated with that specific categories
        $club_ids = Videoclub::select("Club_id")->where('category_id',$id)->get();

        //getting palyers id that are associated with that specific categories
        $player_ids = Videoplayer::select("Player_id")->where('category_id',$id)->get();

        //getting leagues id that are associated with that specific categories
        $league_ids = Leaguecategory::select("league_id")->where('category_id',$id)->get();


        if($slider_id!=null)
        {
            $video_id=Slidervideo::select("Video_id")->wherein('Slider_id',$slider_id)->get();
            $videos=Video::orderBy('video_sorting')->wherein('id',$video_id)->get();
            foreach ($videos as $k => $v) {

                $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));

                $slider_array[$k]['id'] = $v->id;
                $slider_array[$k]['title'] = $v->title_en;
                $slider_array[$k]['title_ar'] = $v->title_ar;
                $slider_array[$k]['description'] = $v->description_en;
                $slider_array[$k]['description_ar'] = $v->description_ar;
                $slider_array[$k]['promo'] = $v->video_promo;
                $slider_array[$k]['image'] = $video_img;

            }
        }
        $obj->Homeslider = $slider_array;


        if($banner_video_id!=null)
        {
            $banner_videos=Video::orderBy('video_sorting')->wherein('id',$banner_video_id)->get();

            foreach ($banner_videos as $k => $v) {

                $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));
                $video_banner_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_banner_img));

                $banner_array[$k]['id'] = $v->id;
                $banner_array[$k]['title'] = $v->title_en;
                $banner_array[$k]['title_ar'] = $v->title_ar;
                $banner_array[$k]['description'] = $v->description_en;
                $banner_array[$k]['description_ar'] = $v->description_ar;
                $banner_array[$k]['banner'] = $video_banner_img;
                $banner_array[$k]['logo'] = $video_img;

            }
            $obj->Homebanner = $banner_array;
        }

        if($genre_id!=null)
        {
            $genres=Video_genre::select("id","name_en","name_ar")->get();
            $obj->category_genre = $genres;

        }

        if($videos_id!=null)
        {
            $videos=Video::orderBy('video_sorting')->wherein('id',$videos_id)->get();


            foreach ($videos as $k => $v) {

                $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));
                $video_banner_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_banner_img));

                $latest_videos_array[$k]['id'] = $v->id;
                $latest_videos_array[$k]['title'] = $v->title_en;
                $latest_videos_array[$k]['title_ar'] = $v->title_ar;
                $latest_videos_array[$k]['description'] = $v->description_en;
                $latest_videos_array[$k]['description_ar'] = $v->description_ar;
                $latest_videos_array[$k]['image'] = $video_img;
                $latest_videos_array[$k]['banner'] = $video_banner_img;

            }
            $obj->homelayout->videos = $latest_videos_array;

        }


        if($club_ids!=null)
        {
            $clubs=Club::orderBy('club_sorting')->wherein('id',$club_ids)->get();

            foreach ($clubs as $k => $v) {

                $club_banner = str_replace('\\', '/', asset('app-assets/images/club/' . $v->club_banner));
                $club_logo = str_replace('\\', '/', asset('app-assets/images/club/' . $v->club_logo));


                $club_array[$k]['id'] = $v->id;
                $club_array[$k]['name'] = $v->name_en;
                $club_array[$k]['name_ar'] = $v->name_ar;
                $club_array[$k]['description'] = $v->description_en;
                $club_array[$k]['description_ar'] = $v->description_ar;
                $club_array[$k]['banner'] = $club_banner;
                $club_array[$k]['logo'] = $club_logo;

            }
            $obj->homelayout->clubs = $club_array;

        }


        if($player_ids!=null)
        {
            $players=Player::orderBy('player_sorting')->wherein('id',$player_ids)->get();

            foreach ($players as $k => $v) {

                $player_banner = str_replace('\\', '/', asset('app-assets/images/player/' . $v->player_banner));
                $player_profile_image = str_replace('\\', '/', asset('app-assets/images/player/' . $v->player_profile_image));

                $player_array[$k]['id'] = $v->id;
                $player_array[$k]['name'] = $v->name_en;
                $player_array[$k]['name_ar'] = $v->name_ar;
                $player_array[$k]['description'] = $v->description_en;
                $player_array[$k]['description_ar'] = $v->description_ar;
                $player_array[$k]['banner'] = $player_banner;
                $player_array[$k]['image'] = $player_profile_image;


            }
            $obj->homelayout->players = $player_array;

        }


        if($league_ids!=null)
        {
            $leagues=League::orderBy('league_sorting')->wherein('id',$league_ids)->get();

            foreach ($leagues as $k => $v) {

                $league_banner = str_replace('\\', '/', asset('app-assets/images/league/' . $v->league_banner));
                $league_profile_image = str_replace('\\', '/', asset('app-assets/images/league/' . $v->league_profile_image));

                $league_array[$k]['id'] = $v->id;
                $league_array[$k]['name'] = $v->name_en;
                $league_array[$k]['name_ar'] = $v->name_ar;
                $league_array[$k]['description'] = $v->description_en;
                $league_array[$k]['description_ar'] = $v->description_ar;
                $league_array[$k]['banner'] = $league_banner;
                $league_array[$k]['image'] = $league_profile_image;

            }
            $obj->homelayout->leagues = $league_array;

        }

        return response()->json(['success' => true, 'status' => $this->successStatus, 'message' => 'Category Related Data Found.', 'data'=> $obj]);

    }

    public function getcategorygenreinfo($category_id, $genre_ids){

        $obj = new stdClass;

        $latest_videos_array = array();
        $banner_array = array();
        $club_array = array();
        $league_array = array();
        $player_array = array();

        $obj->homelayout = new stdClass;


        //getting video id of banner_id of that specific category and genre both
        $banner_video_id = Adv_banner::select("id")->where('category_id',$category_id)
            ->where('genre_id','=',$genre_ids)
            ->get();

        if($banner_video_id!=null)
        {
            $banner_videos=Video::orderBy('video_sorting')->wherein('id',$banner_video_id)->get();

            foreach ($banner_videos as $k => $v) {

                $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));
                $video_banner_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_banner_img));

                $banner_array[$k]['id'] = $v->id;
                $banner_array[$k]['title'] = $v->title_en;
                $banner_array[$k]['title_ar'] = $v->title_ar;
                $banner_array[$k]['description'] = $v->description_en;
                $banner_array[$k]['description_ar'] = $v->description_ar;
                $banner_array[$k]['banner'] = $video_banner_img;
                $banner_array[$k]['logo'] = $video_img;

            }
            $obj->Homebanner = $banner_array;
        }



        // getting Video ids of that specific category and genre both
        $video_ids = Videogenre::select("video_id")->where('category_id',$category_id)
            ->where('genre_id',$genre_ids)
            ->distinct()
            ->get();

        $videos = Video::orderBy('video_sorting')->wherein('id', $video_ids)->get();


        if($videos!=null){
            foreach ($videos as $k => $v) {

                $video_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_img));
                $video_banner_img = str_replace('\\', '/', asset('app-assets/images/video/' . $v->video_banner_img));

                $latest_videos_array[$k]['id'] = $v->id;
                $latest_videos_array[$k]['title'] = $v->title_en;
                $latest_videos_array[$k]['title_ar'] = $v->title_ar;
                $latest_videos_array[$k]['description'] = $v->description_en;
                $latest_videos_array[$k]['description_ar'] = $v->description_ar;
                $latest_videos_array[$k]['image'] = $video_img;
                $latest_videos_array[$k]['banner'] = $video_banner_img;

            }
            $obj->homelayout->videos = $latest_videos_array;


        }


        // getting Club ids of that specific category and genre both
        $club_ids = VideoClub::select("Club_id")->wherein('Video_id', $video_ids)
            ->distinct()
            ->get();
        // getting Clubs of that specific category and genre both
        $clubs = Club::orderBy('club_sorting')->wherein('id', $club_ids)->get();
        if($clubs!=null){
            foreach ($clubs as $k => $v) {

                $club_banner = str_replace('\\', '/', asset('app-assets/images/club/' . $v->club_banner));
                $club_logo = str_replace('\\', '/', asset('app-assets/images/club/' . $v->club_logo));

                $club_array[$k]['id'] = $v->id;
                $club_array[$k]['name'] = $v->name_en;
                $club_array[$k]['name_ar'] = $v->name_ar;
                $club_array[$k]['description'] = $v->description_en;
                $club_array[$k]['description_ar'] = $v->description_ar;
                $club_array[$k]['banner'] = $club_banner;
                $club_array[$k]['logo'] = $club_logo;

            }
            $obj->homelayout->clubs = $club_array;
        }


        // getting Player ids of that specific category and genre both
        $player_ids = VideoPlayer::select("Player_id")->wherein('Video_id', $video_ids)
            ->distinct()
            ->get();
        // getting Players of that specific category and genre both
        $players = Player::orderBy('player_sorting')->wherein('id', $player_ids)->get();
        if($players!=null){
            foreach ($players as $k => $v) {

                $player_banner = str_replace('\\', '/', asset('app-assets/images/player/' . $v->player_banner));
                $player_profile_image = str_replace('\\', '/', asset('app-assets/images/player/' . $v->player_profile_image));

                $player_array[$k]['id'] = $v->id;
                $player_array[$k]['name'] = $v->name_en;
                $player_array[$k]['name_ar'] = $v->name_ar;
                $player_array[$k]['description'] = $v->description_en;
                $player_array[$k]['description_ar'] = $v->description_ar;
                $player_array[$k]['banner'] = $player_banner;
                $player_array[$k]['image'] = $player_profile_image;

            }
            $obj->homelayout->players = $player_array;

        }


        // getting league ids of that specific category and genre both
        $leagues_ids = Leaguecategory::select("league_id")->wherein('video_id', $video_ids)
            ->distinct()
            ->get();

//        if($leagues_ids!=null){
//            echo "yes";
//        }
//        else{
//            echo "no";
//        }


        if($leagues_ids!=null){

            // getting Leagues of that specific category and genre both
            $leagues = League::orderBy('league_sorting')->wherein('id', $leagues_ids)->get();

            foreach ($leagues as $k => $v) {

                $league_banner = str_replace('\\', '/', asset('app-assets/images/league/' . $v->league_banner));
                $league_profile_image= str_replace('\\', '/', asset('app-assets/images/league/' . $v->league_profile_image));


                $league_array[$k]['id'] = $v->id;
                $league_array[$k]['name'] = $v->name_en;
                $league_array[$k]['name_ar'] = $v->name_ar;
                $league_array[$k]['description'] = $v->description_en;
                $league_array[$k]['description_ar'] = $v->description_ar;
                $league_array[$k]['banner'] = $league_banner;
                $league_array[$k]['image'] = $league_profile_image;

            }
            $obj->homelayout->leagues = $league_array;

        }

        return response()->json(['success' => true, 'status' => $this->successStatus, 'message' => 'Category Genre Related Data Found.', 'data'=> $obj]);


    }



}




