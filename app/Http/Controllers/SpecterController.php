<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class SpecterController extends Controller
{
    //

    public function submitsearch(Request $request){

        //dd($request);

        $searchtext = $request->searchtext;
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $searchtext = trim($searchtext);
        $startdate = str_replace("-","",$startdate);
        $enddate = str_replace("-","",$enddate);

        $data = array();

        $data["user"] = Auth::user()->id;
        $data["entity"] = $searchtext;
        $data["startdate"] = $request->startdate;
        $data["enddate"] = $request->enddate;
        $data["created_at"] = date('Y-m-d H:i:s');

        $history = DB::table('history')->insert($data);

        $ch = curl_init();
  
        $url = $this->url()."/search";

        if(!empty($request->startdate) && !empty($request->enddate)){
            $dataArray = ['text_input' => $searchtext,'start_date' => $startdate, 'end_date' => $enddate];
        }else if(!empty($request->startdate)){
            $dataArray = ['text_input' => $searchtext,'start_date' => $startdate];
        }else{
            $dataArray = ['text_input' => $searchtext];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if($result){
                //dd($result["map_data"]);
                $time_lapse = $result["time_lapse"];
                $map_data = $result["map_data"];
                $search_table_data = $result["search_table_data"];
                $entities_table = $result["entities_table"];
                $entity_graph = $result["entity_graph"];
                $web_results = $result["web_results"];
                $pep_results = $result["pep_results"];
                $court_cases = $result["court_cases"];

                $sources = array();

                foreach($search_table_data as $media){
                    if(array_key_exists($media["media_house"], $sources)){
                        $sources[$media["media_house"]]++;
                    }else{
                        $sources[$media["media_house"]] = 1;
                    }
                }

                $locator = array();
                $count_locator = 0;
                foreach($map_data as $map){

                    $location = explode(",", $map["location_label"]);
                    if(isset($location["1"]) && isset($location["2"])){
                    $count_locator++;
                    $map_location = trim($location["1"].", ".$location["2"], ")");
                    $map_location = trim($map_location);
                        if(array_key_exists($map_location, $locator)){
                            $locator[$map_location]++;

                        //dd($locator[$map_location]);
                        }else{
                            $locator[$map_location] = 1;
                        }
                    }

                }
                

                //dd($locator);

                if(!empty($request->startdate) && !empty($request->enddate)){
                
                    return view("process.results", ["time_lapse" => $time_lapse, "map_data" => $map_data, "search_table_data" => $search_table_data, "entities_table" => $entities_table, "entity_graph" => $entity_graph, "web_results" => $web_results, "pep_results" => $pep_results, 'court_cases' => $court_cases, 'sources' => $sources, 'count_locator' => $count_locator, 'locator' => $locator, 'startdate' => $startdate, 'enddate' => $enddate]);

                }else if(!empty($request->startdate)){
                
                    return view("process.results", ["time_lapse" => $time_lapse, "map_data" => $map_data, "search_table_data" => $search_table_data, "entities_table" => $entities_table, "entity_graph" => $entity_graph, "web_results" => $web_results, "pep_results" => $pep_results, 'court_cases' => $court_cases, 'sources' => $sources, 'count_locator' => $count_locator, 'locator' => $locator, 'startdate' => $startdate]);

                }else{
                
                    return view("process.results", ["time_lapse" => $time_lapse, "map_data" => $map_data, "search_table_data" => $search_table_data, "entities_table" => $entities_table, "entity_graph" => $entity_graph, "web_results" => $web_results, "pep_results" => $pep_results, 'court_cases' => $court_cases, 'sources' => $sources, 'count_locator' => $count_locator, 'locator' => $locator]);

                }


            }else{
              //dd($result);
              return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }
    }


    public function compare(){

        return view('compare');
    }


    public function submitcompare(Request $request){


        //dd($request);

        $searchtext1 = $request->entity1;
        $searchtext2 = $request->entity2;
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $searchtext1 = trim($searchtext1);
        $searchtext2 = trim($searchtext2);
        $startdate = str_replace("-","",$startdate);
        $enddate = str_replace("-","",$enddate);


        $data = array();

        $data["entity"] = $searchtext1." vs ".$searchtext2;
        $data["startdate"] = $request->startdate;
        $data["enddate"] = $request->enddate;
        $data["created_at"] = date('Y-m-d H:i:s');

        $ch = curl_init();
  
        $url = $this->url()."/compare";

        if(!empty($request->startdate) && !empty($request->enddate)){
            $dataArray = ['entity_one' => $searchtext1, 'entity_two' => $searchtext2, 'start_date' => $startdate, 'end_date' => $enddate];
        }else if(!empty($request->startdate)){
            $dataArray = ['entity_one' => $searchtext1, 'entity_two' => $searchtext2, 'start_date' => $startdate];
        }else{
            $dataArray = ['entity_one' => $searchtext1, 'entity_two' => $searchtext2];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);

        //dd($response);
            
        if(curl_error($ch)){
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if($result){
                //dd($result['co_events']);
                $co_events = $result["co_events"];
                $co_crimes = $result["co_crimes"];
                $co_entity_freq = $result["co_entity_freq"];
                $co_events_map = $result["co_events_map"];
                $compare_locations = $result["compare_locations"];
                $compare_top_entities = $result["compare_top_entities"];
                $compare_crimes = $result["compare_crimes"];

                //dd($co_crimes);

                $sources = array();

                foreach($co_events as $media){
                    $location = explode(",", $media["event_location"]);
                    if(isset($location["1"]) && isset($location["2"])){
                    $map_location = trim($location["1"].", ".$location["2"]);

                    if(array_key_exists($map_location, $sources)){
                        $sources[$map_location]++;
                    }else{
                        $sources[$map_location] = 1;
                        }
                    }
                }



                $locator = array();
                $count_locator = 0;
                foreach($co_events_map as $map){

                    $location = explode(",", $map["event_location"]);
                    if(isset($location["1"]) && isset($location["2"])){
                    $count_locator++;
                    $map_location = trim($location["1"].", ".$location["2"], ")");
                    $map_location = trim($map_location);
                        if(array_key_exists($map_location, $locator)){
                            $locator[$map_location]++;

                        //dd($locator[$map_location]);
                        }else{
                            $locator[$map_location] = 1;
                        }
                    }

                }
                

                
                //25 graph barchart
                $crimes = array();

                foreach($co_crimes as $co_crime){

                    if(array_key_exists($co_crime['crime_prediction'], $crimes)){
                        $crimes[$co_crime['crime_prediction']] += $co_crime['frequency'];
                    }else{
                        $crimes[$co_crime['crime_prediction']] = $co_crime['frequency'];
                        }
                    }

                
                //28 bubble chart
                $crime_freq = array();

                foreach($co_entity_freq as $co_entity){

                    if(array_key_exists($co_entity['entity_type'], $crime_freq)){
                        $crime_freq[$co_entity['entity_type']] += $co_entity['frequency'];
                    }else{
                        $crime_freq[$co_entity['entity_type']] = $co_entity['frequency'];
                        }
                    }

                //31 map showing entity one locations
                $clocation1 = array();
                $count_location1 = 0;
                foreach($compare_locations["entity_one"] as $location1){

                    $locations1 = explode(",", $location1["event_location"]);
                    if(isset($locations1["1"]) && isset($locations1["2"])){
                    $count_location1++;
                    $cmap_location1 = trim($locations1["1"].", ".$locations1["2"]);

                        if(array_key_exists($cmap_location1, $clocation1)){
                            $clocation1[$cmap_location1] += $location1['frequency'];
                        }else{
                            $clocation1[$cmap_location1] = $location1['frequency'];
                        }
                    }

                }


                //32 map showing entity two locations
                $clocation2 = array();
                $count_location2 = 0;
                foreach($compare_locations["entity_two"] as $location2){

                    $locations2 = explode(",", $location2["event_location"]);
                    if(isset($locations2["1"]) && isset($locations2["2"])){
                    $count_location2++;
                    $cmap_location2 = trim($locations2["1"].", ".$locations2["2"]);

                        if(array_key_exists($cmap_location2, $clocation2)){
                            $clocation2[$cmap_location2] += $location2['frequency'];
                        }else{
                            $clocation2[$cmap_location2] = $location2['frequency'];
                        }
                    }

                }


                //35 graph piechart
                $top_entity1 = array();

                foreach($compare_top_entities["entity_one"] as $top1){

                    if(array_key_exists($top1['entity_type'], $top_entity1)){
                        $top_entity1[$top1['entity_type']] += $top1['frequency'];
                    }else{
                        $top_entity1[$top1['entity_type']] = $top1['frequency'];
                        }
                    }


                //36 graph piechart
                $top_entity2 = array();

                foreach($compare_top_entities["entity_two"] as $top2){

                    if(array_key_exists($top2['entity_type'], $top_entity2)){
                        $top_entity2[$top2['entity_type']] += $top2['frequency'];
                    }else{
                        $top_entity2[$top2['entity_type']] = $top2['frequency'];
                        }
                    }

                
                //39 graph barchart
                $compare_crime1 = array();

                foreach($compare_crimes["entity_one"] as $crimes1){

                    if(array_key_exists($crimes1['crime_prediction'], $compare_crime1)){
                        $compare_crime1[$crimes1['crime_prediction']] += $crimes1['frequency'];
                    }else{
                        $compare_crime1[$crimes1['crime_prediction']] = $crimes1['frequency'];
                        }
                    }


                //39 graph barchart
                $compare_crime2 = array();

                foreach($compare_crimes["entity_two"] as $crimes2){

                    if(array_key_exists($crimes2['crime_prediction'], $compare_crime2)){
                        $compare_crime2[$crimes2['crime_prediction']] += $crimes2['frequency'];
                    }else{
                        $compare_crime2[$crimes2['crime_prediction']] = $crimes2['frequency'];
                        }
                    }

                
                return view("process.compareresults", ["co_events" => $co_events, "co_crimes" => $co_crimes, "co_entity_freq" => $co_entity_freq, "co_events_map" => $co_events_map, "compare_locations" => $compare_locations, "compare_top_entities" => $compare_top_entities, "compare_crimes" => $compare_crimes, 'sources' => $sources, 'locator' => $locator, 'count_locator' => $count_locator, 'crimes' => $crimes, 'crime_freq' => $crime_freq, 'clocation1' => $clocation1, 'clocation2' => $clocation2, 'count_location1' => $count_location1, 'count_location2' => $count_location2, 'top_entity1' => $top_entity1, 'top_entity2' => $top_entity2, 'compare_crime1' => $compare_crime1, 'compare_crime2' => $compare_crime2]);


            }else{
              //dd($result);
              return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }
    }


    public function history(){

        if(Auth::user()->role == 1){
            $historys = DB::table('history')->orderBy('created_at', 'desc')->get();
        }else{
            $historys = DB::table('history')->where('user', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }
        

        return view('history', ['historys' => $historys]);
    }


    public function gentities(Request $request){


        $searchtext = $request->searchtext;
        if(isset($request->startdate)){
            $startdate = $request->startdate;
            $startdate = str_replace("-","",$startdate);
        }
        if(isset($request->enddate)){
            $enddate = $request->enddate;
            $enddate = str_replace("-","",$enddate);
        }

        $searchtext = trim($searchtext);


        //Level 2 Search No 8 Table Showing All similar entities retrieved from Data Core
        $ch = curl_init();
  
        $url = $this->url()."/tables";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'entity_tl', 'start_date' => $startdate, 'end_date' => $enddate];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'entity_tl', 'start_date' => $startdate];
        }else{
            $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'entity_tl' ];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if(count($result) != 0){
                //dd($result);
                $time_lapse = $result["time_lapse"];
                $table_data = $result["table_data"];
                //dd($table_data);
            }else{
              //dd($result);
              $table_data = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }

                

            //Level 2 Search Table 9 List of Similar Enitities and frequency of Events for Retrieved results

            $ch = curl_init();

            $url = $this->url()."/tables";

            if(isset($request->startdate) && isset($request->enddate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'similar_entities', 'start_date' => $startdate, 'end_date' => $enddate];
            }else if(isset($request->startdate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'similar_entities', 'start_date' => $startdate];
            }else{
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'table_id' => 'similar_entities' ];
            }
            
          
            $data = http_build_query($dataArray);
          
            $getUrl = $url."?".$data;
          
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
               
            $response = curl_exec($ch);
                
            if(curl_error($ch)){
                //dd($response);
                return response()->json([
                        "message" => "error",
                        "info" => "Request Error: ". curl_error($ch)
                    ]);
            }else{
                //echo $response;
            }
               
            curl_close($ch);


            if ($response) {
                //dd($response);
                $result = json_decode($response, true);
                // print_r($result);
                if(count($result) != 0){
                    //dd($result);
                    $time_lapse = $result["time_lapse"];
                    $table_datas = $result["table_data"];

            }else{
              //dd($result);
              $table_datas = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }



            //Level 2 Search Map 10 Map Showing Location of Events similar to queried string

            $ch = curl_init();

            $url = $this->url()."/maps";

            if(isset($request->startdate) && isset($request->enddate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', 'start_date' => $startdate, 'end_date' => $enddate];
            }else if(isset($request->startdate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', 'start_date' => $startdate];
            }else{
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', ];
            }
            
          
            $data = http_build_query($dataArray);
          
            $getUrl = $url."?".$data;
          
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
               
            $response = curl_exec($ch);
                
            if(curl_error($ch)){
                //dd($response);
                return response()->json([
                        "message" => "error",
                        "info" => "Request Error: ". curl_error($ch)
                    ]);
            }else{
                //echo $response;
            }
               
            curl_close($ch);


            if ($response) {
                //dd($response);
                $result = json_decode($response, true);
                // print_r($result);
                if(count($result) != 0){
                    //dd($result);
                    $time_lapse = $result["time_lapse"];
                    $map_data = $result["map_data"];
                

                $locator = array();
                $count_locator = 0;
                foreach($map_data as $map){

                    $location = explode(",", $map["event_location"]);
                    if(isset($location["1"]) && isset($location["2"])){
                    $count_locator++;
                    $map_location = trim($location["1"].", ".$location["2"]);
                        if(array_key_exists($map_location, $locator)){
                            $locator[$map_location]++;

                        //dd($locator[$map_location]);
                        }else{
                            $locator[$map_location] = 1;
                        }
                    }

                }

            }else{
              //dd($result);
              $map_data = [];
              $locator = [];
              $count_locator = 0;
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }


            //Level 2 Graph Piecharts 11 Crime Distribution for Retrieved Events

            $ch = curl_init();

            $url = $this->url()."/graphs";

            if(isset($request->startdate) && isset($request->enddate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', 'start_date' => $startdate, 'end_date' => $enddate];
            }else if(isset($request->startdate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', 'start_date' => $startdate];
            }else{
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', ];
            }
            
          
            $data = http_build_query($dataArray);
          
            $getUrl = $url."?".$data;
          
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
               
            $response = curl_exec($ch);
                
            if(curl_error($ch)){
                //dd($response);
                return response()->json([
                        "message" => "error",
                        "info" => "Request Error: ". curl_error($ch)
                    ]);
            }else{
                //echo $response;
            }
               
            curl_close($ch);


            if ($response) {
                //dd($response);
                $result = json_decode($response, true);
                // print_r($result);
                if(count($result) != 0){
                    //dd($result);
                    $time_lapse = $result["time_lapse"];
                    $graph_datas = $result["graph_data"];

                    $crimes = array();
                    foreach($graph_datas as $graphs){

                            if(array_key_exists($graphs['crime_prediction'], $crimes)){
                                $crimes[$graphs['crime_prediction']]++;
                            }else{
                                $crimes[$graphs['crime_prediction']] = 1;
                            }
                        }
            }else{
              //dd($result);
              $graph_datas = [];
              $crimes = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }



            //Level 2 Graph Barchart 12 Enitities frequency  (Events from results)

            $ch = curl_init();

            $url = $this->url()."/graphs";

            if(isset($request->startdate) && isset($request->enddate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'entity_tl', 'start_date' => $startdate, 'end_date' => $enddate];
            }else if(isset($request->startdate)){
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'entity_tl', 'start_date' => $startdate];
            }else{
                $dataArray = ['search_level' => 2, 'entity_name' => $searchtext, 'graph_id' => 'entity_tl', ];
            }
            
          
            $data = http_build_query($dataArray);
          
            $getUrl = $url."?".$data;
          
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
               
            $response = curl_exec($ch);
                
            if(curl_error($ch)){
                //dd($response);
                return response()->json([
                        "message" => "error",
                        "info" => "Request Error: ". curl_error($ch)
                    ]);
            }else{
                //echo $response;
            }
               
            curl_close($ch);


            if ($response) {
                //dd($response);
                $result = json_decode($response, true);
                // print_r($result);
                if(count($result) != 0){
                    //dd($result);
                    $time_lapse = $result["time_lapse"];
                    $graph_data = $result["graph_data"];

                    $sources = array();

                    foreach($graph_data as $media){
                    if(array_key_exists($media["media_house"], $sources)){
                        $sources[$media["media_house"]]++;
                    }else{
                        $sources[$media["media_house"]] = 1;
                    }
                }

            }else{
              //dd($result);
              $graph_data = [];
              $sources = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }


        if(isset($request->startdate) && isset($request->enddate)){
            return view("gentities", ["time_lapse" => $time_lapse, "map_data" => $map_data, "table_data" => $table_data, "graph_data" => $graph_data, "sources" => $sources, "count_locator" => $count_locator, "locator" => $locator, 'start_date' => $startdate, 'end_date' => $enddate, 'table_datas' => $table_datas, 'graph_datas' => $graph_datas, 'crimes' => $crimes]);
        }else if(isset($request->startdate)){
            return view("gentities", ["time_lapse" => $time_lapse, "map_data" => $map_data, "table_data" => $table_data, "graph_data" => $graph_data, "sources" => $sources, "count_locator" => $count_locator, "locator" => $locator, 'start_date' => $startdate, 'table_datas' => $table_datas, 'graph_datas' => $graph_datas, 'crimes' => $crimes]);
        }else{
            return view("gentities", ["time_lapse" => $time_lapse, "map_data" => $map_data, "table_data" => $table_data, "graph_data" => $graph_data, "sources" => $sources, "count_locator" => $count_locator, "locator" => $locator, 'table_datas' => $table_datas, 'graph_datas' => $graph_datas, 'crimes' => $crimes]);
        }

                
            


    }


    public function sentities(Request $request){
        
        $searchtext = $request->searchtext;
        $event_id = trim($request->event_id);
        if(isset($request->startdate)){
            $startdate = $request->startdate;
            $startdate = str_replace("-","",$startdate);
        }
        if(isset($request->enddate)){
            $enddate = $request->enddate;
            $enddate = str_replace("-","",$enddate);
        }

        $searchtext = trim($searchtext);

        //Level 3 Search No 14 and 15 List of all “PERSON” Entities that appear in Event
        $ch = curl_init();
  
        $url = $this->url()."/tables";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'entity_tl', 'start_date' => $startdate, 'end_date' => $enddate];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'entity_tl', 'start_date' => $startdate];
        }else{
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'entity_tl' ];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if(count($result) != 0){
                //dd($result['table_data']);
                $time_lapse = $result["time_lapse"];
                $table_data1 = $result["table_data"];
                //dd($table_data);
            }else{
              //dd($result);
              $table_data1 = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }





        //Level 3 Search No 16 Map Showing Location of Event
        $ch = curl_init();
  
        $url = $this->url()."/maps";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', 'start_date' => $startdate, 'end_date' => $enddate, 'event_id' => $event_id];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', 'start_date' => $startdate, 'event_id' => $event_id];
        }else{
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'map_id' => 'entity_tl', 'event_id' => $event_id];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if(count($result) != 0){
                //dd($result);
                $time_lapse = $result["time_lapse"];
                $map_data = $result["map_data"];
                
                $locator = array();
                $count_locator = 0;
                foreach($map_data as $map){

                    $location = explode(",", $map["event_location"]);
                    if(isset($location["1"]) && isset($location["2"])){
                    $count_locator++;
                    $map_location = trim($location["1"].", ".$location["2"]);
                        if(array_key_exists($map_location, $locator)){
                            $locator[$map_location]++;
                        }else{
                            $locator[$map_location] = 1;
                        }
                    }

                }

            }else{
              $map_data = [];
              $locator = [];
              $count_locator = 0;
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }



        //Level 3 Search No 17 Piechart Crime Distribution for Retrieved Event
        $ch = curl_init();
  
        $url = $this->url()."/graphs";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', 'start_date' => $startdate, 'end_date' => $enddate, 'event_id' => $event_id];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', 'start_date' => $startdate, 'event_id' => $event_id];
        }else{
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'graph_id' => 'graph_pie', 'event_id' => $event_id];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if(count($result) != 0){
                //dd($result);
                $time_lapse = $result["time_lapse"];
                $crime_data = $result["graph_data"];
                
                //25 graph barchart
                $crimes = array();

                foreach($crime_data as $crime){

                    if(array_key_exists($crime['crime_prediction'], $crimes)){
                        $crimes[$crime['crime_prediction']] += $crime['frequency'];
                    }else{
                        $crimes[$crime['crime_prediction']] = $crime['frequency'];
                        }
                    }

            }else{
              $crime_data = [];
              $crimes = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }



        //Level 3 Search No 18 Table/ Profile List
        $ch = curl_init();
  
        $url = $this->url()."/tables";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'event_details', 'start_date' => $startdate, 'end_date' => $enddate, 'event_id' => $event_id];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'event_details', 'start_date' => $startdate, 'event_id' => $event_id];
        }else{
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'table_id' => 'event_details', 'event_id' => $event_id];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            //dd($response);
            $result = json_decode($response, true);
            // print_r($result);
            if(count($result) != 0){
                //dd($result);
                $time_lapse = $result["time_lapse"];
                $table_data2 = $result["table_data"];
                
                
            }else{
              //dd($result);
              $table_data2 = [];
            }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }




        //Level 3 Search No 19 Graph: Network Graph
        $ch = curl_init();

        //$event_id = 'NGA_f65a748c-201f-4724-8ab1-c615a0a02659';
  
        $url = $this->url()."/link_analysis";

        if(isset($request->startdate) && isset($request->enddate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'start_date' => $startdate, 'end_date' => $enddate, 'id' => $event_id];
        }else if(isset($request->startdate)){
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'start_date' => $startdate, 'id' => $event_id];
        }else{
            $dataArray = ['search_level' => 3, 'entity_name' => $searchtext, 'id' => $event_id];
        }
        
      
        $data = http_build_query($dataArray);
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
            
        if(curl_error($ch)){
            
            return response()->json([
                    "message" => "error",
                    "info" => "Request Error: ". curl_error($ch)
                ]);
        }else{
            //echo $response;
        }
           
        curl_close($ch);


        if ($response) {
            $result = json_decode($response, true);
                if(count($result) != 0){
                    //dd($result);
                    $time_lapse = $result["time_lapse"];
                    $link_analysis = $result["link_analysis"];
                    

                    //25 graph barchart
                    $heads = array();
                    $relations = array();
                    $tails = array();

                    foreach($link_analysis as $analysis){

                        $head = explode("|", $analysis['head']);
                        $relation = explode("|", $analysis['relation']);
                        $tail = explode("|", $analysis['tail']);

                            for($h = 0; $h < count($head); $h++){

                                if(array_key_exists($head[$h], $heads)){
                                    $heads[$head[$h]]++;
                                }else{
                                    $heads[$head[$h]] = 1;
                                }

                            }


                            for($r = 0; $r < count($relation); $r++){

                                if(array_key_exists($relation[$r], $relations)){
                                    $relations[$relation[$r]]++;
                                }else{
                                    $relations[$relation[$r]] = 1;
                                }

                            }



                            for($t = 0; $t < count($tail); $t++){

                                if(array_key_exists($tail[$t], $tails)){
                                    $tails[$tail[$t]]++;
                                }else{
                                    $tails[$tail[$t]] = 1;
                                }

                            }

                        
                        }
                    
                }else{
                  
                  $link_analysis = [];
                  $heads = [];
                  $relations = [];
                  $tails = [];
                }
          }else{
            //dd($response);
            return response()->json([
                    "message" => "error",
                    "info" => "Something went wrong while trying to retrieve result, try again."
                ]);
          }



        return view('sentities', ['table_data1' => $table_data1, 'map_data' => $map_data, 'locator' => $locator, 'count_locator' => $count_locator, 'crime_data' => $crime_data, 'crimes' => $crimes, 'table_data2' => $table_data2, 'link_analysis' => $link_analysis, 'heads' => $heads, 'relations' => $relations, 'tails' => $tails]);
    }


    public function usertable(){

        $users = DB::table('users')->orderBy('created_at', 'desc')->get();

        return view('usertable', ['users' => $users]);
    }
}
