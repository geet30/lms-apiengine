<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadFile')) {
    function uploadFile($url, $fileContent, $privacy)
    {
        return Storage::disk('s3')->put($url, $fileContent, $privacy);
    }
}

if (!function_exists('uploadFilePrivate')) {
    function uploadFilePrivate($url, $fileContent)
    {
     return Storage::disk('s3-private')->put($url,$fileContent,'private');
    }
}

if (!function_exists('getPrivateFile')) {
    function getPrivateFile($url)
    {
        $s3Client = new \Aws\S3\S3Client([
            'credentials' => [
                'key' => config('env.BUCKET_ACCESS_KEY_PRIVATE'),
                'secret' => config('env.BUCKET_SECRET_KEY_PRIVATE')
            ],
            'region' => config('env.BUCKET_REGION_PRIVATE'),
            'version' => 'latest',
        ]);
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => config('env.BUCKET_FOLDER_PRIVATE'),
            'Key' => $url,
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+30 minutes');
        $presignedUrl = (string) $request->getUri();
        return $presignedUrl;
    }

}