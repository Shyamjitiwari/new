<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\LessonSubCategory;
use App\User;
use Illuminate\Http\Request;
use App\LectureCategory;
use App\LectureSubCategory;
use App\Lecture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Role;

class ViewLectureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student|teacher|parent');
    }

    public function getLectureCategories(){

        $user = Auth::user();
        $role = $user->role->role;
        $studentRoleId = Role::where('role','student')->value('id');
        if($role == "student") {
            $categoriesData = DB::table('users as u')
                ->where('u.id', $user->id)
                ->join('lecture_category_user as lcu','lcu.user_id','=','u.id')
                ->join('lecture_categories as lc','lc.id','=','lcu.lecture_category_id')
                ->where('lc.is_deleted', 0)
                ->select('lc.*')
                ->get();

        } else if($role == "parent"){
            $categoriesData = DB::table('users as u')
                ->where('u.phone_number', $user->phone_number)
                ->where('u.role_id', $studentRoleId)
                ->join('lecture_category_user as lcu','lcu.user_id','=','u.id')
                ->join('lecture_categories as lc','lc.id','=','lcu.lecture_category_id')
                ->where('lc.is_deleted', 0)
                ->select('lc.*')
                ->distinct()
                ->get();
        }else {
            $categoriesData = LectureCategory::where('is_deleted', false)->orderby('priority')->get();
        }
        $categories = array();
        foreach($categoriesData as $category){
            $url = "/subCategories/".$category->id."";
            $dataArray = ["id" =>$category->id,
                      "name" => $category->name,
                      "url" => $url,
                      "password" => $category->password,
                    ];
            array_push($categories,$dataArray);           
        }
        if($role == "student"){
            return view('view_lecture.categories')->with(['categories' =>$categories]);   
        }
        if($role == "parent"){
            return view('view_lecture.categories_parent')->with(['categories' =>$categories]);   
        }
        elseif($role == "teacher"){
            return view('view_lecture.categories_teacher')->with(['categories' =>$categories]);   
        }
    }

    public function getLectureSubCategories($categoryId)
    {
        $user = Auth::user();
        $role = $user->role->role;
        
        $studentRoleId = Role::where('role','student')->value('id');
        $isAuthorize = false;
        // check if student has been authorized to view this sub categories
        if($role == "student" ) {
            if(!Helper::isLectureCategoryPresent($user->id, $categoryId))
            {
                return back()->with('danger', 'You are not authorized to view this category');
            }
        }else if($role == "parent"){
            $students = User::where(['phone_number'=> $user->phone_number,
                                     'role_id' => $studentRoleId])->get();
           foreach($students as $student){
                if(Helper::isLectureCategoryPresent($student->id, $categoryId)){
                    $isAuthorize = true;
                    break;
                }   
           }
           if(!$isAuthorize){
                return back()->with('danger', 'You are not authorized to view this category');
           }
        }

        if($categoryId != null)
        {
            $subCategoriesData = LectureSubCategory::where('category_id',$categoryId)->orderby('priority')->get();
        } else {
            $subCategoriesData = LectureSubCategory::where('is_deleted', false)->orderby('priority')->get();
        }

        $subCategories = array();

        foreach($subCategoriesData as $subCategory)
        {
            $url = "/lectures/".$subCategory->id."";
            $dataArray = ["id" =>$subCategory->id,
                      "name" => $subCategory->name,
                      "url" => $url,
                    ];
            array_push($subCategories,$dataArray);           
        }

        if($role == "student")
        {
            return view('view_lecture.sub_categories')->with(['subCategories' =>$subCategories]);   
        }
        if($role == "parent")
        {
            return view('view_lecture.sub_categories_parent')->with(['subCategories' =>$subCategories]);   
        }
        elseif($role == "teacher")
        {
            return view('view_lecture.sub_categories_teacher')->with(['subCategories' =>$subCategories]);   
        }
        
    }
    public function getLectures($subCategoryId){
        $user = Auth::user();
        $role = $user->role->role;
      
        $studentRoleId = Role::where('role','student')->value('id');
        $isAuthorize = false;
        // check if student has been authorized to view this sub categories
        if($role == "student" ) {
            if(!Helper::isLectureCategoryPresent($user->id, $subCategoryId))
            {
                return back()->with('danger', 'You are not authorized to view this category');
            }
        }else if($role == "parent"){
            $students = User::where(['phone_number'=> $user->phone_number,
                                     'role_id' => $studentRoleId])->get();
           foreach($students as $student){
                if(Helper::isLectureCategoryPresent($student->id, $subCategoryId)){
                    $isAuthorize = true;
                    break;
                }   
           }
           if(!$isAuthorize){
                return back()->with('danger', 'You are not authorized to view this category');
            }
        }

        if($subCategoryId != null){
            $lecturesData = Lecture::where('sub_category_id',$subCategoryId)
                            ->orderby('priority')->get();
        }
        else{
            $lecturesData = Lecture::where('is_deleted', false)
                            ->orderby('priority')->get();
        }
        $lectures = array();
        foreach($lecturesData as $lecture){
            $dataArray = ["id" =>$lecture->id,
                        "name" => $lecture->title,
                        "url" => $lecture->link,
                    ];
            array_push($lectures,$dataArray);           
        }
        if($role == "student"){
            return view('view_lecture.lectures')->with(['lectures' =>$lectures]);   
        }
        if($role == "parent"){
            return view('view_lecture.lectures_parent')->with(['lectures' =>$lectures]);   
        }
        elseif($role == "teacher"){
            return view('view_lecture.lectures_teacher')->with(['lectures' =>$lectures]);   
        }  
    }

    public function getLectureCategoriesForTeachers(){
        $categoriesData = LectureCategory::where('is_deleted', false)->orderby('priority')->get();
        $categories = array();
        foreach($categoriesData as $category){
            $url = "/subCategories/".$category->id."";
            $dataArray = ["id" =>$category->id,
                      "name" => $category->name,
                      "url" => $url,
                    ];
            array_push($categories,$dataArray);           
        }
        return view('view_lecture.categories_teacher')->with(['categories' =>$categories]);   
    }

    public function getLectureSubCategoriesForTeachers($categoryId){
        if($categoryId != null){
            $subCategoriesData = LectureSubCategory::where('category_id',$categoryId)
                                ->orderby('priority')->get();
        }
        else{
            $subCategoriesData = LectureSubCategory::where('is_deleted', false)
                                 ->orderby('priority')->get();
        }
        $subCategories = array();
        foreach($subCategoriesData as $subCategory){
            $url = "/lectures/".$subCategory->id."";
            $dataArray = ["id" =>$subCategory->id,
                          "name" => $subCategory->name,
                          "url" => $url,
                    ];
            array_push($subCategories,$dataArray);           
        }
        return view('view_lecture.sub_categories_teacher')->with(['subCategories' =>$subCategories]);   
    }
    public function getLecturesForTeachers($subCategoryId){
        if($subCategoryId != null){
            $lecturesData = Lecture::where('sub_category_id',$subCategoryId)
                            ->orderby('priority')->get();
        }
        else{
            $lecturesData = Lecture::where('is_deleted', false)
                            ->orderby('priority')->get();
        }
        $lectures = array();
        foreach($lecturesData as $lecture){
            $dataArray = ["id" =>$lecture->id,
                        "name" => $lecture->title,
                        "url" => $lecture->link,
                    ];
            array_push($lectures,$dataArray);           
        }
        return view('view_lecture.lectures_teacher')->with(['lectures' =>$lectures]);   
    }
    
    public function addStudentLectureCategory(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->role;
        $studentRoleId = Role::where('role','student')->value('id');

        $this->validate($request, [
            'password' => 'required',
        ]);

        $lectureCategory = LectureCategory::where('password', $request->input('password'))
            ->where('is_deleted', 0)
            ->first();
        
        $isCategoryAlreadyAdded = false;
            if($lectureCategory)
            {
                if($role == 'student'){
                    if (Helper::isLectureCategoryPresent(Auth::user()->id, $lectureCategory->id)){
                        return back()->with('danger', 'Category has already been added');
                    }
                }else if($role == 'parent'){
                    $students = User::where(['phone_number'=> $user->phone_number,
                                             'role_id' => $studentRoleId])->get();
                    foreach($students as $student){
                        if(Helper::isLectureCategoryPresent($student->id, $lectureCategory->id)){
                            $isCategoryAlreadyAdded = true;
                            break;
                        }   
                    }
                    if($isCategoryAlreadyAdded){
                        return back()->with('danger', 'Category has already been added');
                    }
                }
                    
                $students = User::where(['phone_number'=> $user->phone_number,
                                         'role_id' => $studentRoleId])->get();
                foreach($students as $student){
                    $student->lecture_categories()->syncWithoutDetaching($lectureCategory);
                }
                return back()->with('success', 'Category added to your list');
    
            } else {
                return back()->with('danger', 'Category does not exist');
            }
    }



    // Following method is to show all the categories, sub_categories and lectures
    // on the same page

    // public function lectures(){
    //     $lectures = array();
    //     $categories = LectureCategory::where('is_deleted', false)->orderby('priority')->get();
        
    //     foreach($categories as $category){
    //         $subCategories = LectureSubCategory::where('category_id', $category->id)->get();
            
    //         foreach($subCategories as $subCategory){
    //             $lectureData = Lecture::where('sub_category_id', $subCategory->id)->get();
    //             if(count($lectureData) > 0){
    //                 $dataArray = ["category" => $category->name,
    //                           "subCategory" => $subCategory->name,
    //                           "lectures" => $lectureData
    //                 ];
    //                 array_push($lectures,$dataArray);
    //             }
    //         }
    //     }
    //     return view('student.lectures')->with(['data' =>$lectures]);
    // }
}
