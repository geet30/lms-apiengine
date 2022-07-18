<?php

namespace App\Rules\Providers;

use Illuminate\Contracts\Validation\Rule;

class TextBoxLengthCheck implements Rule
{
    protected $textData="";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->textData = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!empty($this->textData)){
            $textLengthWithHtml=strlen($this->textData);
            // echo strlen($this->textData);
            //  dd($this->textData).'oooooo';
            // $temp=trim(strip_tags($this->textData));
            // echo '---'.$temp.'-';
            //  dd(strlen($temp));
        
            // echo $temp;die;
            // $str = preg_replace("(\S)","",$temp);
            // echo $str;
            // $textLength=strlen($str); 
            // echo $textLength;
            // $tt= strlen($temp)-$textLength;
            // dd($tt);
        if($textLengthWithHtml+1 > env('EDITOR_TEXT_LENGTH')){
          return false;
        }else{
           return true;        }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('providers.textbox_length_validation');
    }
}
