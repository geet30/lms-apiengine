<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Affiliate, AffiliateTemplate};
use App\Http\Requests\Affiliates\AffiliateEmailSmsRequest;
use Illuminate\Support\Facades\Session;

class AffiliateTemplateController extends Controller
{
    /**
     * Display list of affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $affiliate_id
     * @return \Illuminate\Http\Illuminate\View\View
     */
    public function emailTemplates(Request $request, $affiliate_id = "")
    {
        try {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_affiliates',$userPermissions,$appPermissions) || !checkPermission('affiliate_templates',$userPermissions,$appPermissions))
            {
                Session::flash('error', trans('auth.permission_error')); 
                return redirect('/affiliates/list');
            }
            $affiliateData = AffiliateTemplate::affiliateData(decryptGdprData($affiliate_id));
            $services = Affiliate::getUserServices(decryptGdprData($affiliate_id));
            return view('pages.affiliates.email-templates.list', compact('affiliate_id', 'services','affiliateData'));
        } catch (\Exception $err) {

            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * Display add or edit affiliate table
     * @param  int $id,$source,$type,$email_type 
     * @param  string  $affiliate_id
     * @return \Illuminate\Http\Illuminate\View\View
     */
    public function addEmailTemplate(Request $request)
    {
        try {
            $editData = null;
            $headArr["title"] = "Add";
            $affiliate_id = $request->affiliate_id;
            $domainOrPool = null;
            $plivoNumbers = null;
            if ($request->id != "") {
                $editData = AffiliateTemplate::getParticulardataSmsEmail($request->id);
                $headArr["title"] = "Edit";
                $source = $editData->type;
                $type = $editData->email_type;
                $email_type = $editData->service_id;
                $template_type = $editData->template_type;
            } else {
                $source = $request->source;
                $type = $request->type;
                $email_type = $request->email_type;
                $template_type = $request->template_type;
            }
            $headArr["link"] = URL('affiliates/templates' . '/' . $affiliate_id);
            $services = Affiliate::getUserServices(decryptGdprData($affiliate_id));
            if ($source == 1) {
                $api = AffiliateTemplate::checkApi(decryptGdprData($affiliate_id));
                if (!$api) {
                    return redirect()->back()->withErrors(['msg' => 'Please create API first to this affiliate']);
                }
                $domainOrPool = AffiliateTemplate::getBounceOrPool($affiliate_id, $email_type);
                if (!$domainOrPool) {
                    return redirect()->back()->withErrors(['msg' => 'Please check sparkpost API key']);
                }
            } else if ($source == 2 && ($type == '1' || $type == '3')) {
                $plivoNumbers = AffiliateTemplate::getPlivoNumbers($affiliate_id, $email_type);
            }
            $parameters = AffiliateTemplate::getHtmlParameter($source, $type, $email_type, $template_type);
            $affiliateData = AffiliateTemplate::affiliateData(decryptGdprData($affiliate_id));
            return view('pages.affiliates.email-templates.components.create_update', compact('affiliate_id', 'source', 'type', 'email_type', 'services', 'parameters', 'editData', 'domainOrPool', 'headArr', 'affiliateData', 'template_type', 'plivoNumbers'));
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * save or update affiliate email template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUpdateEmailTemplate(AffiliateEmailSmsRequest $request)
    {
        try {
            return AffiliateTemplate::saveUpdateEmailTemplate($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * get table filter data
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDataEmailSmsTemplate(Request $request)
    {
        try {
            return AffiliateTemplate::getDataEmailSmsTemplate($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * delete affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteTemplate(Request $request)
    {
        try {
            return AffiliateTemplate::deleteTemplate($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * change status of  affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emailTemplateStatus(Request $request)
    {
        try {
            return AffiliateTemplate::emailTemplateStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
