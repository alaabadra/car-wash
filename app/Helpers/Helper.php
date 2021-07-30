<?php

use App\Models\Dictionary;
use App\Models\ManageEmployees\Screen;

//codetables sys_code_types
//1- colors
//2- brands
//3- car_status
//4- carpet_size
//5- wash_type

function description_lang($english_desc, $other_desc){
    $lang = session('lang');
    if ($lang == 'ar')
        return $other_desc;
    else
        return $english_desc;
}

function t($id){
    $data = Dictionary::where('dic_id',$id)->first();
    return @description_lang($data['name'], $data['name_ar']);
}

function mearge_dic($file){
    $jsonString = file_get_contents(base_path('resources/lang/Dic/' . $file));
    $data = json_decode($jsonString, true);
    foreach ($data['dic'] as $dic) {
        $dictionary = Dictionary::find($dic['dic_id']);
        if ($dictionary) {
            $dictionary->name = $dic['name'];
            $dictionary->name_ar = $dic['name_ar'];
        } else {
            $dictionary = new Dictionary;
            $dictionary->dic_id=$dic['dic_id'];
            $dictionary->name = $dic['name'];
            $dictionary->name_ar = $dic['name_ar'];
        }
        $dictionary->save();
    }
}

function mearge_screens($file){
    $jsonString = file_get_contents(base_path('resources/setup/' . $file));
    $data = json_decode($jsonString, true);
    foreach ($data['screen'] as $screen) {
        $screen_route=strtolower(trim($screen['screen_route']));
        $screen2=Screen::where('screen_route','like',$screen_route)->first();

        if ($screen2) {
            $screen2->module_id = $screen['module_id'];
            $screen2->module_name = $screen['module_name'];
            $screen2->screen_name = $screen['screen_name'];
            $screen2->operation_type = $screen['operation_type'];
            $screen2->sort = $screen['sort'];
        } else {
            $screen2 = new Screen;
            $screen2->screen_route = $screen['screen_route'];
            $screen2->module_id = $screen['module_id'];
            $screen2->module_name = $screen['module_name'];
            $screen2->screen_name = $screen['screen_name'];
            $screen2->operation_type = $screen['operation_type'];
            $screen2->sort = $screen['sort'];
        }
        $screen2->save();
    }
}
