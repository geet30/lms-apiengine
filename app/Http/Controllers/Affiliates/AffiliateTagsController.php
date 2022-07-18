<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Affiliate};

class AffiliateTagsController extends Controller
{
    //get master tags
    public function manageTags($userId)
    {
        $tags = Affiliate::getTags($userId);
        return $tags;
    }
    //update tag a/c to tag_id and aff user_id
    function saveTags(Request $request)
    {
        try {
            $response = Affiliate::saveAffTags($request);
            return response()->json(['status' => $response['status'], 'message' => $response['message']]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /*get save tags in a/c to user_id and tag_id*/
    public function getAffTagsDetail(Request $request, $userId)
    {
        try {
            $tags = Affiliate::getTags($userId, $request);
            return $tags;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
