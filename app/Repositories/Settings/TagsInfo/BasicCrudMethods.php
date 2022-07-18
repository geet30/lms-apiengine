<?php

namespace App\Repositories\Settings\TagsInfo;

use App\Models\{
    Tag,
};
use DB;

trait BasicCrudMethods
{
    public static function getFilters($condition = null, $columns = '*')
	{
		$query = self::select($columns);
		if ($condition) {
			$query = $query->where($condition);
		}
        $query = self::where($condition)->select($columns);
        return $query->orderBy('created_at','desc')->get()->toArray();
	}

    public static function modifyTagResponse($tagData)
	{
		$data = [];
		foreach ($tagData as $tag) {

			array_push($data, [
				'id' => $tag['id'],
                'name' => $tag['name'],
                'is_highlighted' =>$tag['is_highlighted'],
                'is_one_in_state' =>$tag['is_one_in_state'],
                'is_top_of_list' => $tag['is_top_of_list'],
                'created_at'=>$tag['created_at'],
                'rank'=>$tag['rank']

			]);
		}
		return $data;
	}

    public static function getTagData()
    {
        return self::orderBy('created_at', 'desc')->get();
    }
    public static function storeTag($request)
    {

        try {
            if ($request) {
                $id = '';
                $isOneInState = 0;
                $isHighlighted = 0;
                $isTopOfList = 0;
                $setForAllPlans = 0;
                $status = true;
                $added = true;
                $msg = 'Tag has been added succesfully';
                if ($request->isHighlighted) {
                    $isHighlighted = 1;
                }
                if ($request->isOneInState) {
                    $isOneInState = 1;
                }
                if ($request->isTopOfList) {
                    $isTopOfList = 1;
                }
                if ($request->setForAllPlans) {
                    $setForAllPlans = 1;
                }
                if (isset($request->tagId) && $request->tagId != "") {
                    $id = $request->tagId; //table id
                    $msg = trans('Tag has been updated succesfully');
                    $added = false;
                }
                $tagData = [
                    'name' => $request->name,
                    'is_highlighted' => $isHighlighted,
                    'is_one_in_state' => $isOneInState,
                    'is_top_of_list' => $isTopOfList,
                    'set_for_all_plans' => $setForAllPlans,
                    'rank' => $request->rank,
                ];
                $tagData['service_id'] = 3;
                $tagData['status'] = 1;
                $tagData['is_deleted'] = 0;
                $existName = self::where('name', '=', $request->name);
                if (isset($request->tagId) && $request->tagId != ""){
                    $existName = $existName->where('id', '!=', $request->tagId);
                }
                $existName = $existName->select('id')->get();
                if (count($existName) > 0) {
                    // return response()->json(['success' => false,'message'=>'Order type already exists.','status'=>422],422);
                    $errors['name'] = 'Tag Name already exists.';
                    return response()->json(['status' => 422, 'errors' => $errors], 422);
                } else {
                    self::updateOrCreate(['id' => $id], $tagData);
                    $tags = self::orderBy('created_at', 'desc')->get()->toArray();
                }
                return response()->json(['tags'=>$tags,'status' => $status, 'message' => $msg, 'added'=>$added], 200);
            }
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function deleteTag($tagId)
    {
        try {
            $tag = self::find($tagId);
            $tag->delete();
            $tags = self::orderBy('created_at', 'desc')->get()->toArray();
            foreach($tags as $tag){
                $tag['created_at'] = dateTimeFormat($tag['created_at']);
            }
            return response()->json(['tags'=>$tags,'status' => true, 'message' => 'Deleted']);
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }
}
