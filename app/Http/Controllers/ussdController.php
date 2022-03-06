<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Lga;
use App\Category;
use App\Facility;
use App\FIQuestionaire;
use App\SSQuestionaire;

class ussdController extends Controller
{
    
     
    static $facilities;
    static $facility_types;
    static $facility_org;
    static $states;
    

    public function onlineUssdMenu(Request $request)
    {
       
       
       $facilities = Facility::all();
       $states = State::all();
       $lgas = Lga::all();
       $facility_types = ["Hospital","Health Center","Therapeutic Feeding unit"];
       $facility_org = ["Government","NGO","UNICEF","Private","Faith-based 
        organization"];

       $sessionId   = $request->get('sessionId');
       $serviceCode = $request->get('serviceCode');
       $phoneNumber = $request->get('phoneNumber');
       $text        = $request->get('text');
        // use explode to split the string text response from Africa's talking gateway into an array.
        $ussd_string_exploded = explode("*", $text);
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);
        if ($text == "") {
            // first response when a user dials our ussd code
           
            $response  = "CON Welcome, please select a questionaire to answer \n";
            $response .= "1. Facility Identification Questionaire \n";
            $response .= "2. Stock Status Questionaire \n";
           
            
        }
        elseif ($level == "1" && $text =="1") {
            
           $response = "CON Enter Data Collector name";
           
            
        }
        elseif ($level == "2" && $ussd_string_exploded[0] == "1") {
            

            $response = "CON Enter Facility Name \n";
            
            
        }
        elseif ($level == "3" && $ussd_string_exploded[0] == "1") {
            

            $response = "CON Enter facility Code \n";
        }
        elseif ($level =="4" && $ussd_string_exploded[0] == "1") {
           
            $response = "CON Please Select Facility type \n";
            $number = 1;
            foreach($facility_types as $type){
                $response .= $number.". ".$type."\n";
                $number++;
            }
        }
        elseif ($level == "5" && $ussd_string_exploded[0] == "1") {
           
            $response = "CON Facility is Operated by which Organisation \n";
            $number = 1;
            foreach($facility_org as $org){
                $response .= $number.". ".$org."\n";
                $number++;
            }
        }
        elseif ($level == "6" && $ussd_string_exploded[0] == "1") {
            
            $response = "CON Please Select State \n";
            $number = 1;
            
            foreach($states as $state){
                $response .= $number.". ".$state->state_name."\n";
                $number++;
            }
        }
        elseif ($level == "7" && $ussd_string_exploded[0] == "1") {
            $selected_state = $states[(int)$ussd_string_exploded[6]];
            
           
            $response = "CON Please Select Local Government area \n";
            $number = 1;
           
            $lgas = $selected_state->lgas;
            foreach($lgas as $lga){
                $response .= $number.". ".$lga->lga_name."\n";
                $number++;
            }
        }
        elseif ($level == "8" && $ussd_string_exploded[0] == "1") {
           
            
            
            $response = "CON Enter name and Title of health facility respondent".count($lgas);
        }
        elseif ($level == "9" && $ussd_string_exploded[0] == "1") {
            
          
            $response = "CON Enter name and Title of household respondent";
        }
        elseif ($level == "10" && $ussd_string_exploded[0] == "1") {
            $fi_response = new FIQuestionaire();
            $fi_response->name_of_data_collector = $ussd_string_exploded[1];
            $fi_response->facility_name = $ussd_string_exploded[2];
            $fi_response->facility_code = $ussd_string_exploded[3];
            $fi_response->facility_type = $ussd_string_exploded[4];
            $fi_response->facility_org = $ussd_string_exploded[5];

            $selected_state = $states[(int)$ussd_string_exploded[6]];
            $fi_response->state_name = $selected_state->state_name;
            $fi_response->state_code = $selected_state->state_code;

            $selected_lga = $lgas[(int)$ussd_string_exploded[7]];
            $fi_response->lga_name = $selected_lga->lga_name;
            $fi_response->lga_code = $selected_lga->lga_code;

            $fi_response->facility_respondent = $ussd_string_exploded[8];
            $fi_response->household_respondent = $ussd_string_exploded[9];
            $fi_response->save();
            $response = "END Your data has been captured successfully! Thank you for Completing This Questionaire";
        }
        elseif ($level =="1" && $text == "2") {
           
            $response = "CON What is the physical count of usable (undamaged, 
            unexpired) RUTF sachets today?";
        }
        
        elseif ($level =="2" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON Is there usable RUTF in stock today? \n (yes = 1, no = 0)";
        }
        elseif ($level =="3" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON Is there any RUTF at this facility that is expired as of 
            today's visit? \n (yes = 1, no = 0)";
        }
        elseif ($level =="4" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON Is there any RUTF at this facility that is damaged as of 
            today's visit? (sachet ripped, perforated, opened, 
            nibbled by pests, or otherwise damaged so as to be 
            unusable) \n (yes = 1, no = 0)";
        }
        elseif ($level =="5" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON What is the physical count of unusable (damaged or 
            expired) RUTF sachets today?";
        }
        elseif ($level =="6" && $ussd_string_exploded[0] == "2") {
            
            $response = "CON Is there a stock card or stock ledger for RUTF? \n (yes = 1, no = 0)";
        }
        elseif ($level =="7" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON Does the stock card or stock ledger have complete 
            records for the past 3 months? \n (yes = 1, no = 0)";
        }
        elseif ($level =="8" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON According to the stock card or stock ledger how 
            many days in the last three months has RUTF been 
            stocked out?";
        }
        elseif ($level =="9" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON Is there a register or tally that records how many 
            sachets of RUTF were dispensed to 
            patients/caregivers? Can you show it to me? \n (yes = 1, no = 0)";
        }
        elseif ($level =="10" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON If there is a register or tally card, does it contain 
            complete records of RUTF distributed to 
            patients/caregivers for the most recent three 
            months? \n (yes = 1, no = 0)";
        }
        elseif ($level =="11" && $ussd_string_exploded[0] == "2") {
           
            $response = "CON According to the tally, what quantity of RUTF was 
            dispensed to patients/caregivers from this site during 
            the most recent three months?";
        }
        elseif ($level =="12" && $ussd_string_exploded[0] == "2") {
            $ss_response = new SSQuestionaire();
            $ss_response->no_of_usable_RTUF = $ussd_string_exploded[1];
            $ss_response->usable_RTUF = $ussd_string_exploded[2];
            $ss_response->expired_RTUF = $ussd_string_exploded[3];
            $ss_response->damaged_RTUF = $ussd_string_exploded[4];
            $ss_response->no_of_damaged_RTUF = $ussd_string_exploded[5];
            $ss_response->sc_available = $ussd_string_exploded[6];
            $ss_response->complete_sc_record = $ussd_string_exploded[7];
            $ss_response->stock_out_days = $ussd_string_exploded[8];
            $ss_response->dispensed_RTUF_record = $ussd_string_exploded[9];
            $ss_response->record_of_distributed_RTUF = $ussd_string_exploded[10];
            $ss_response->no_of_dispensed_RTUF = $ussd_string_exploded[11];
            $ss_response->save();

            $response = "END Your data has been captured successfully! Thank you for Completing This Questionaire";
        }
        header('Content-type: text/plain');
        echo $response;
    }
}
