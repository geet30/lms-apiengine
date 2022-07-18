<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Tag,
};
use App\Http\Requests\Settings\Tags\TagRequest;
use DB;

class TagsSettingController extends Controller
{
    public function index(Request $request){
        $condition = [];
        if ($request->isMethod('post')) {
            $condition['is_deleted'] = 0;
            if (isset($request->name)) {
                $condition['name']= $request->name;
            }
            $tagData = Tag::getFilters( 
            $condition, 
            ['*']);
            $getData = Tag::modifyTagResponse($tagData);
            return response()->json(['tags' => $getData], 200);
        } 
        else{
        $tagsData = Tag::getTagData();
        }
        return view('pages.settings.tags.list',compact('tagsData'));
     }
    public function store(TagRequest $request){
        try {
            return Tag::storeTag($request);
            
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
     }
     public function deleteTag($id){
        try {
            return Tag::deleteTag($id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
     }
}
