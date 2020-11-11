<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\LanguageLine;
use Lang;
use App\Locale;
use App\LocaleFile;

class LocalizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function localization(){
        return view('localization.admin_index');
    }

    public function getAllLocals(){
        $allLocales = Locale::all();
        return response()->json(['locales'=> $allLocales],200);
    }

    public function selectLocalizedStrings(Request $request){
        $lang = Locale::where('id',$request->input('locale'))->value('name');
        return view('');
    }

    public function getProjectsForLocalization(){
        $dataArray = array();
        $data = ['id' => 1,
                 'name' => 'Portal',];
        array_push($dataArray, $data);
        $data = ['id' => 2,
                 'name' => 'Website',];

        array_push($dataArray, $data);
        return response()->json(['projects'=> $dataArray],200);
    }

    public function getLocalizedStrings(Request $request){
        $lang = Locale::where('id',$request->input('locale'))->value('name');
        
        if($request->project == 1){
            $locale_files = LocaleFile::all();
            $dataArray = array();

            foreach($locale_files as $locale_file){
                $path = base_path().'/resources/lang/'.$lang.'/'.$locale_file->name.'.php';
                $arrayLang = Lang::get($locale_file->name);
                if (gettype($arrayLang) == 'string') $arrayLang = array();

                foreach($arrayLang as $key => $value){
                    $data = ['string_key' => $key ,
                            'string_value' => stripslashes($value),
                            'locale_file' => $locale_file->name ];
                    array_push($dataArray, $data);
                }
            }
        }
        elseif($request->project == 2){
            $allWebsiteStrings = LanguageLine::all();
            $dataArray = array();
            foreach($allWebsiteStrings as $websiteString){
                $textLocales = $websiteString->text;
                foreach($textLocales as $key => $value){
                    if($key == $lang){
                        $value = stripslashes($value);
                        $data = ['string_key' => $websiteString->key ,
                                'string_value' => stripslashes($value),
                                'locale_file' => $websiteString->group ];
                        array_push($dataArray, $data);
                    }  
                }
            }
        }

        return response()->json(['localized_strings'=> $dataArray],200);
        
    }

    public function editLocaleString(Request $request){
        $lang = Locale::where('id',$request->input('locale'))->value('name');
        $keyToUpdate = $request->string_key;
        $updatedValue = $request->string_value;

        if($request->project == 1){
            $locale_file = $request->locale_file;

            $path = base_path().'/resources/lang/'.$lang.'/'.$locale_file.'.php';
            $arrayLang = Lang::get($locale_file);
            if (gettype($arrayLang) == 'string') $arrayLang = array();
            
            $arrayLang[$keyToUpdate] = $updatedValue;

            $content = "<?php\n\nreturn\n[\n";
            foreach ($arrayLang as $key => $value) {
                $value = stripslashes($value);
                $content .= "\t'".$key."' => '".addslashes($value)."',\n";
            }
            $content .= "];";

            file_put_contents($path, $content);
        }
        elseif($request->project == 2){
            $string = LanguageLine::where('key',$keyToUpdate)->first();
            $stringLocales = $string->text;
            foreach($stringLocales as $key => $value){
                if($key == "en"){
                    $stringLocales['en'] = $updatedValue;
                    $string->text = $stringLocales;
                    $string->save();
                }
            }
        }
        return response()->json(['response_msg'=>'Data updated'],200);
    }

    // public function getWebsiteStrings(){

    //     $allWebsiteStrings = LanguageLine::all();

    //     $dataArray = array();
    //     foreach($allWebsiteStrings as $websiteString){
    //         $textLocales = $websiteString->text;
    //         foreach($textLocales as $key => $value){
    //             if($key == "en"){
    //                 $value = stripslashes($value);
    //                 $data = ['string_key' => $websiteString->key ,
    //                          'string_value' => stripslashes($value),
    //                         'locale_file' => $websiteString->group ];
    //                 array_push($dataArray, $data);
    //             }  
    //         }
    //     }

    //     $a = count($dataArray);
    //     $b= $a;
    // }

    // public function editAWebsiteString(){
    //     $string = LanguageLine::where('key','about_cwu_question')->first();
    //     $stringLocales = $string->text;
    //     foreach($stringLocales as $key => $value){
    //         if($key == "en"){
    //             $stringLocales['en'] = "About Code With Us";
    //             $string->text = $stringLocales;
    //             $string->save();
    //         }
    //     }
    // }

}
