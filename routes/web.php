<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Affiliates\CommissionController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\DmoVdoController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lead\{LeadController, SaleSubmissionController};
use App\Http\Controllers\Providers\ProviderController;
use App\Http\Controllers\Auth\TwoFaController;
use App\Http\Controllers\Affiliates\AffiliateController;
use App\Http\Controllers\Affiliates\AffiliateTemplateController;
use App\Http\Controllers\Plans\PlanController;
use App\Http\Controllers\Plans\Broadband\BroadbandController;
use App\Http\Controllers\Plans\MobilePlanController;
use App\Http\Controllers\Plans\EnergySolarPlanRate;
use App\Http\Controllers\Plans\EnergyPlanRateController;
use App\Http\Controllers\Affiliates\ManageUserController;
use App\Http\Controllers\Affiliates\MatrixController;
use App\Http\Controllers\Affiliates\AffiliateRetentionController;
use App\Http\Controllers\Affiliates\TargetController;
use App\Http\Controllers\Affiliates\ApikeyController;
use App\Http\Controllers\Affiliates\{AffiliateReconController,AffiliateTagsController};
use App\Http\Controllers\Affiliates\AssignPermission;
use App\Http\Controllers\Plans\EnergyDemandController;
use App\Http\Controllers\Addons\AddonsController;
use App\Http\Controllers\Affiliates\IpWhitelistController;
use App\Http\Controllers\Providers\{PostCodeController, StatesController, LifeSupportController, SchemaController};
use App\Http\Controllers\Plans\Energy\{PlanUploadController, PlanRateUploadController};
use App\Http\Controllers\Reports\SalesQaReportController;
use App\Http\Controllers\Settings\{
    DistributorController,
    LifeSupportEquipmentController,
    MasterTariffCodeController,
    SettingController,
    MasterSettingController,
    TagsSettingController,
    ImportTariffRateController,
    DiallerIgnoreDataController,
    ExportSettingsController
};
use App\Http\Controllers\Usage\SetlimtsController;
use App\Http\Controllers\Recon\ReconController;
use App\Http\Controllers\Affiliates\SearchAddressController;
use App\Http\Controllers\MobileSettings\{ColorsController, ContractController, MobileHandsetsController, BrandsController, RamController, StorageController, VariantController};
use App\Http\Controllers\Plans\Mobile\{MobilePlanUploadController,ManagePhoneController};
use App\Http\Controllers\Providers\ManageProviderPhoneController;
use App\Http\Controllers\ManageUser\UserController;

use App\Http\Controllers\Statistics\ManageStatisticController;
use App\Http\Requests\Settings\ExportSettingRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/fill-dialler', function () {
    \Artisan::call('cache:ignoredata');
    return response()->json(['success' => true]);
});

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);


        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth')->middleware('two-factor')->middleware('check-status');
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});

/** Two Factor Routes Begin **/
Route::prefix('2fa')->group(function () {
    Route::get('verify', [TwoFaController::class, 'validateView'])->name('2fa.verify');
    Route::post('validate-otp', [TwoFaController::class, 'validateOTP'])->name('2fa.validate');
    Route::get('cancel', [TwoFaController::class, 'cancel']);

    Route::group(['middleware' => ['auth', 'two-factor', 'check-status']], function () {
        Route::get('force', [TwoFaController::class, 'apply2FAView'])->name('2fa.force');
        Route::post('force', [TwoFaController::class, 'apply2FA'])->name('2fa.post.force');
        Route::get('two-factor-auth-setting', [TwoFaController::class, 'twoFactorAuthSetting'])->name('2fa.auth.settings');
        Route::get('manage/{id}', [TwoFaController::class, 'twoFactorAuthSetting'])->name('2fa.settings');
        Route::post('enable-disable-2fa', [TwoFaController::class, 'enableDisableTwoFactor'])->name('2fa.manage');
        Route::post('recovery-codes', [TwoFaController::class, 'postRecoveryCodes'])->name('2fa.recovery-codes');
        Route::post('download-recovery-codes', [TwoFaController::class, 'downloadRecoveryCodes'])->name('2fa.download-codes');
        Route::post('disable-2fa', [TwoFaController::class, 'forceDisable2FA'])->name('2fa.disable');
    });
});
/** Two Factor Routes End **/

Route::group(['middleware' => ['auth', 'two-factor', 'check-status']], function () {
    //Route::get('providers', [SettingsController::class, 'index'])->name('settings.index');
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });

    // Visits listing
    Route::prefix('visits')->group(function () {
        Route::get('list', [LeadController::class, 'index'])->name('visits.list');
        Route::get('detail/{verticalId}/{productId}', [LeadController::class, 'detail'])->name('visits.detail');
        Route::post('get-affiliate-by-service', [LeadController::class, 'getAffiliateByService']);
        Route::post('get-sub-affiliate-list', [LeadController::class, 'getSubAffiliateList']);
        Route::post('get-sub-affiliate-list', [LeadController::class, 'getSubAffiliateList']);
        Route::post('filter-data', [LeadController::class, 'index']);
        Route::get('view/{id}', [LeadController::class, 'view'])->name('visits.view');
    });
    // Leads listing
    Route::prefix('leads')->group(function () {
        Route::get('list', [LeadController::class, 'index'])->name('leads.list');
        Route::post('filter-data', [LeadController::class, 'index']);
        Route::post('get-affiliate-by-service', [LeadController::class, 'getAffiliateByService']);
        Route::post('get-sub-affiliate-list', [LeadController::class, 'getSubAffiliateList']);
        Route::get('view/{id}', [LeadController::class, 'view'])->name('leads.view');
        Route::get('detail/{verticalId}/{productId}', [LeadController::class, 'detail'])->name('leads.detail');
        Route::post('get-affiliate-by-service', [LeadController::class, 'getAffiliateByService']);
        Route::post('get-sub-affiliate-list', [LeadController::class, 'getSubAffiliateList']);
        Route::post('generate-lead-csv', [LeadController::class, 'getGenerateCsv']);
        Route::post('send-email-lead',[LeadController::class,'emailFromLead']);
        Route::post('send-sms-lead',[LeadController::class,'addSMSTemplate']);
        Route::post('get-plivo-data',[LeadController::class,'getPlivoData']);
    });

    Route::prefix('provider')->group(function () {
        Route::get('list', [ProviderController::class, 'index'])->name('provider.list');
        Route::post('list', [ProviderController::class, 'index']);
        Route::get('create', [ProviderController::class, 'create'])->name('provider.create');
        Route::post('store', [ProviderController::class, 'store']);
        Route::post('contact/store', [ProviderController::class, 'storeContact']);
        Route::get('contact/delete/{id}', [ProviderController::class, 'deleteContact']);
        Route::get('edit/{id}/{service_id}', [ProviderController::class, 'edit'])->name('provider.edit');
        Route::post('update', [ProviderController::class, 'update']);
        Route::get('view_ajax/{id}', [ProviderController::class, 'showAjax'])->name('provider.view');

        Route::post('concession_data', [ProviderController::class, 'showConcessionDataAjax'])->name('provider.concession.data');

        Route::get('link-provider/{id}', [ProviderController::class, 'getAssignUserToProvider'])->name('provider.link-provider');
        Route::post('assign-providers-affiliates', [ProviderController::class, 'postProviderAffiliates']);
        Route::post('manage-ips', [ProviderController::class, 'postManageIps'])->name('provider.manage-ips');
        Route::get('get-manage-ips', [ProviderController::class, 'getManageIps'])->name('provider.get-manage-ips');
        Route::post('manage-token', [ProviderController::class, 'postManageToken'])->name('provider.manage-token');
        Route::post('manage-debit-info-ip', [ProviderController::class, 'setDebitInfoIp'])->name('provider.manage-debit-info-ip');
        Route::post('store-update-checkbox', [ProviderController::class, 'storeOrUpdateCheckbox']);
        Route::post('update-status', [ProviderController::class, 'updateStatus']);
        Route::post('check-get-permission', [ProviderController::class, 'checkUserGetPermission']);

        // postcodes tab
        Route::get('get-postcodes/{user_id}/{distributor_id}/{energy_type?}', [PostCodeController::class, 'getPostcodes']);
        Route::get('get-distributors/{user_id}/{energy_type}', [PostCodeController::class, 'getDistributorsByEnergyType']);
        Route::post('assign-postcodes', [PostCodeController::class, 'assignPostcodes']);

        // sale submission tab
        Route::post('password-protected-sale-submission', [ProviderController::class, 'postPasswordProtectedSaleSubmission']);
        Route::post('sale-submission', [ProviderController::class, 'postSaleSubmission']);
        Route::get('get-sale-submission/{provider}/{type}', [ProviderController::class, 'getSaleSubmission']);

        // sftp tab
        Route::post('add-sftp', [ProviderController::class, 'addSftp']);
        Route::get('get-sftps/{provider_id}', [ProviderController::class, 'getSftps']);
        Route::delete('delete-sftp/{sftp_id}', [ProviderController::class, 'deleteSftp']);
        Route::get('change-sftp-status/{sftp_id}', [ProviderController::class, 'changeSftpStatus']);
        Route::get('change-provider-sftp-status/{user_id}', [ProviderController::class, 'changeProviderSftpStatus']);
        Route::post('sftp-logs', [ProviderController::class, 'updateSftpLog']);

        Route::get('terms_and_condition_title', [ProviderController::class, 'getSpecificTermData']);
        Route::get('state/tele/consent', [ProviderController::class, 'getStateOrTeleData']);
        Route::get('remove_content_checkbox', [ProviderController::class, 'removeCheckbox']);
        Route::delete('outbound-link/{id}', [ProviderController::class, 'deleteOutBoundLink']);
        Route::post('create_update/custom/field', [ProviderController::class, 'saveEditCustomField']);
        Route::post('delete/custom/field', [ProviderController::class, 'deleteCustomField']);
        Route::post('get-plans', [ProviderController::class, 'getPlans']);
        Route::post('assigned-plans', [ProviderController::class, 'assignPlanToField']);
        Route::post('get-category', [ProviderController::class, 'getCategory']);
        Route::post('save-provider-logo', [ProviderController::class, 'saveProviderLogo']);


        // states tab
        Route::post('assign-providers-states', [StatesController::class, 'index']);
        Route::post('change-state-status', [StatesController::class, 'changeStatus']);
        Route::post('retention-allowed', [StatesController::class, 'retentionAlloweded']);
        Route::post('deletestate', [StatesController::class, 'deleteState']);

        // life support equipments
        Route::delete('life-support-equipment/{id}', [ProviderController::class, 'deleteEquipment']);
        Route::get('change-life-support-status/{id}', [ProviderController::class, 'changeEquipmentStatus']);

        // move-in tab
        Route::post('grace-day', [ProviderController::class, 'providerMovinData']);
        Route::post('provider-movin-details', [ProviderController::class, 'getProviderMovinDetail']);
        Route::post('save-eic_content_data', [ProviderController::class, 'saveEicContentData']);
        Route::post('get_distibutors', [ProviderController::class, 'getMovinDistributors']);
        Route::get('provider-decrypt', [ProviderController::class, 'removeDecryption']);

        // suburb tab
        Route::post('get-suburbs', [ProviderController::class, 'getSuburbs']);
        Route::post('assign-suburbs', [ProviderController::class, 'assignSuburbs']);
        Route::post('add-suburbs/{user_id}', [ProviderController::class, 'addSuburbs']);
        Route::post('change-suburb-status', [ProviderController::class, 'changeSuburbStatus']);
        Route::post('change-suburb-status-bulk', [ProviderController::class, 'changeSuburbStatusBulk']);
        Route::post('delete-suburb', [ProviderController::class, 'deleteSuburb']);
        Route::post('import-suburb-postcodes', [ProviderController::class, 'importSuburbPostcodes']);
        Route::get('download-suburb-postcodes-sample-sheet', [ProviderController::class, 'downloadSuburbPostcodesSampleSheet']);

        Route::post('get-postcode-suburbs', [ProviderController::class, 'getPostcodeSuburbs']);
        Route::post('get-postcode-postcodes', [ProviderController::class, 'getPostcodePostcodes']);
        Route::post('store_provider_lifesupport', [LifeSupportController::class, 'store']);
        Route::get('get_provider_lifesupport/{provider_id}/{life_support_equip_id}', [LifeSupportController::class, 'get']);

        // Route::get('plans/edits/{plan_id}', [PlanController::class, 'edit'])->name('energyplans.edit');
        Route::prefix('plans')->group(function () {
            // energy routes
            Route::prefix('energy')->group(function () {

                Route::match(['get', 'post'], '{energyType}/list/{provider_id}', [PlanController::class, 'index'])->name('energyplans.list');
                //Route::get('{energyType}/list/{provider_id}', [PlanController::class, 'index'])->name('energyplans.list');
                // Route::post('{energyType}/list/{provider_id}', [PlanController::class, 'Postindex'])->name('energyplans.filter-list');

                // Route::post('{energyType}/list/{provider_id}', [PlanController::class, 'index'])->name('energyplans.list');
                Route::get('get-edit/{plan_id}', [PlanController::class, 'edit'])->name('energyplans.edit');
                Route::get('get-remarketing/{id?}', [PlanController::class, 'getRemarketingData'])->name('energyplans.get-remarketing');
                Route::get('get-eic-content/{id?}', [PlanController::class, 'getEicData'])->name('energyplans.get-eic');
                Route::get('get-eic-checkbox-content/{id?}', [PlanController::class, 'getEicCheckboxData'])->name('energyplans.get-eic-checkbox');
                Route::get('get-plan-tags/{id?}', [PlanController::class, 'getPlanTagData'])->name('energyplans.get-tags');
                Route::post('change-status', [PlanController::class, 'postChangeStatus'])->name('plan.changestatus');
                Route::post('update-agent-status', [PlanController::class, 'updateAgentStatus'])->name('plan.updateagentstatus');

                Route::Post('update', [PlanController::class, 'update'])->name('energyplans.update');
                Route::get('solar-rates/{provider_id}/{plan_id}', [EnergySolarPlanRate::class, 'index'])->name('energyplans.solar-rates');
                Route::get('solar-rates-premium/{provider_id}/{plan_id}', [EnergySolarPlanRate::class, 'indexPremium'])->name('energyplans.solar-rates-premium');
                Route::post('solar-rates-add-edit', [EnergySolarPlanRate::class, 'createUpdateSolar'])->name('solar.add-edit');
                Route::delete('solar-rates-delete/{id}', [EnergySolarPlanRate::class, 'deleteSolar'])->name('solar.delete');
                Route::post('solar-chnage-status', [EnergySolarPlanRate::class, 'postChangeStatus'])->name('solar.status');
                Route::get('solar-plan-change-status/{id}', [EnergySolarPlanRate::class, 'setSolarPlanStatus'])->name('solar.set-plan-status');
                Route::get('plan-rates/{plan_id}', [EnergyPlanRateController::class, 'index'])->name('energyplans.rates');
                Route::get('edit-plan-rate/{plan_id}/{energy_id}', [EnergyPlanRateController::class, 'edit'])->name('energyplans.edit-rates');
                Route::post('update-plan-rate', [EnergyPlanRateController::class, 'update'])->name('energyplans.update-rates');
                Route::post('update-lpg-plan-rate', [EnergyPlanRateController::class, 'updateLpgPlan'])->name('energyplans.lpg-update-rates');
                Route::post('copy-dmo-content', [EnergyPlanRateController::class, 'postCopyDmoContent'])->name('energyplans.copy-dmo-content');
                Route::get('rates/demand/{rate_id}/{distributor_id}/{plan_type}', [EnergyDemandController::class, 'index'])->name('energyplans.demand');
                Route::post('rates/demand/create-update', [EnergyDemandController::class, 'create'])->name('energyplans.demand.create-update');
                Route::get('rates/demand-rates/{rate_id}/{plan_rate_id}/{plan_type}', [EnergyDemandController::class, 'getDemandRate'])->name('energyplans.demand.rates');
                Route::post('rates/demand/rate/create-update', [EnergyDemandController::class, 'createDemandRate'])->name('energyplans.demand.rate.create-update');
                Route::post('get-master-tariff-codes', [EnergyDemandController::class, 'getMasterTariff'])->name('energyplans.master-tariff');
                Route::post('tariff-info-and-rate', [EnergyDemandController::class, 'getDemandTariffLimit'])->name('energyplans.tariff-rate-limit');

                Route::post('add-plan-rate-limit', [EnergyPlanRateController::class, 'createPlanRateLimit'])->name('energyplans.aad.rate.limt');
                Route::post('plan-rate-limit', [EnergyPlanRateController::class, 'getRateLimts'])->name('energyplans.getrate.limit');
                Route::post('get-limit-list', [EnergyPlanRateController::class, 'postPlanLimit'])->name('energyplans.limit');

                Route::post('upload-plans', [PlanUploadController::class, 'uploadPlans'])->name('energy.upload.plans');
                Route::post('download-plans', [PlanUploadController::class, 'downloadPlans'])->name('energy.download.plans');

                Route::post('upload-plan-rate-list', [PlanRateUploadController::class, 'uploadPlanRateList'])->name('energy.upload.plan.rate.list');
                Route::post('upload-plan-missing-rate-list', [PlanRateUploadController::class, 'uploadMissingPlanRateList'])->name('energy.upload.missing.plan.rate.list');
                Route::post('download-plan-rate-list', [PlanRateUploadController::class, 'downloadPlanRateList'])->name('energy.download.plan.rate.list');

                Route::post('get_plan_dmo', [EnergyPlanRateController::class, 'getPlanDmo'])->name('energyplans.dmoplan');
            });

            // broadband plans routes
            Route::prefix('broadband')->group(function () {
                Route::get('{providerId}', [BroadbandController::class, 'index']);
                Route::get('edit/{planId}', [BroadbandController::class, 'edit']);
                Route::get('{providerId}/create', [BroadbandController::class, 'create']);
                Route::post('{providerId}/store', [BroadbandController::class, 'store']);
                Route::post('update', [BroadbandController::class, 'update']);
                Route::post('update-included-addons', [BroadbandController::class, 'updateIncludedAddons']);
                Route::post('update-terms-condition', [BroadbandController::class, 'updateTermCondition']);
                Route::post('update-plan-eic-content', [BroadbandController::class, 'updateEicContent']);
                Route::post('update-plan-eic-content-checkbox', [BroadbandController::class, 'updateEicContentCheckbox']);
                Route::post('delete-plan-eic-content-checkbox', [BroadbandController::class, 'deleteEicContentCheckbox']);
                Route::get('get-technology-type/{id}', [BroadbandController::class, 'getTechnologyType']);
                Route::post('save-plan-fees', [BroadbandController::class, 'savePlanFee']);
                Route::post('delete-plan-fees', [BroadbandController::class, 'deletePlanFee']);
                Route::post('save-other-addon', [BroadbandController::class, 'saveOtherAddon']);
                Route::post('status', [BroadbandController::class, 'changeStatus']);
                Route::post('{providerId}', [BroadbandController::class, 'index']);
            });

            // mobile plans routes

            Route::post('/mobile/upload-plans', [MobilePlanUploadController::class, 'uploadPlans'])->name('mobile.upload.plans');
            Route::post('/mobile/download-plans', [MobilePlanUploadController::class, 'downloadPlans'])->name('mobile.download.plans');
            Route::post('/mobile/save-plan-fees', [MobilePlanController::class, 'savePlanFee']);
            Route::post('/mobile/delete-plan-fees', [MobilePlanController::class, 'deletePlanFee']);
            Route::prefix('/mobile/{providerId}')->group(function () {
                Route::match(['get', 'post'], '/', [MobilePlanController::class, 'index']);
                Route::get('/create', [MobilePlanController::class, 'create']);
                Route::post('/save', [MobilePlanController::class, 'store']);
                Route::get('/edit/{planId}', [MobilePlanController::class, 'edit']);
                Route::put('/save/{planId}', [MobilePlanController::class, 'update']);
                Route::post('change-status/{id}', [MobilePlanController::class, 'changePlanStatus']);
                Route::delete('/{id}', [MobilePlanController::class, 'destroyPlan']);
                Route::delete('/{planId}/reference/{id}', [MobilePlanController::class, 'destroyPlanReference']);

                Route::get('/manage-phone/{planId}', [ManagePhoneController::class, 'index']);
                Route::post('/manage-phone/{planId}', [ManagePhoneController::class, 'index']);
                Route::get('/get-phone-list/{planId}', [ManagePhoneController::class, 'fetchHandsetsToAssignPlan']);

                Route::get('/manage-phone/{planId}/manage-phone-variant/{handsetId}', [ManagePhoneController::class, 'getPhoneVariant']);
                Route::post('/manage-phone/{planId}/manage-phone-variant/{handsetId}', [ManagePhoneController::class, 'getPhoneVariant']);

                Route::get('/manage-phone/{planId}/edit-phone-variant/{handsetId}/{variantId}', [ManagePhoneController::class, 'editPhoneVariant']);

                Route::post('/assign-phone', [ManagePhoneController::class, 'postAssignPhone']);

                Route::post('/phones/change-status/{id}', [ManagePhoneController::class, 'changePhoneStatus']);

                Route::post('/phones/variants/change-status/{id}', [ManagePhoneController::class, 'changeVariantStatus']);
            });
            Route::post('/mobile/plan-handset-variant/details', [ManagePhoneController::class, 'postEditAssignedVariantDetail']);
        });
        // Manage assigned phones
        Route::prefix('assigned-handsets/{providerId}')->group(function () {
            Route::get('/list', [ManageProviderPhoneController::class, 'index']);
            Route::post('/list', [ManageProviderPhoneController::class, 'index']);
            Route::post('/change-status/{id}', [ManageProviderPhoneController::class, 'changeStatus']);
            Route::post('/remove-handset/{id}', [ManageProviderPhoneController::class, 'deleteHandsetProvider']);

            Route::get('/manage-phone-variant/{handsetId}/list', [ManageProviderPhoneController::class, 'getVariantListing']);
            Route::post('/manage-phone-variant/{handsetId}/list', [ManageProviderPhoneController::class, 'getVariantListing']);

            Route::post('/manage-phone-variant/{handsetId}/change-status/{id}', [ManageProviderPhoneController::class, 'changeProviderVariantStatus']);

            Route::post('/manage-phone-variant/{handsetId}/remove-variant', [ManageProviderPhoneController::class, 'deleteProviderVariant']);

            Route::post('/manage-phone-variant/{handsetId}/store_vha_code', [ManageProviderPhoneController::class, 'storeVHACode']);
            Route::post('/manage-phone-variant/{handsetId}/view-variant-images', [ManageProviderPhoneController::class, 'showVariantImages']);
        });

        Route::post('/manage-phone/view-variant-images',[ManageProviderPhoneController::class, 'showVariantImages']);

        /** Sale schema routes **/
        Route::get('schema/send', [SchemaController::class, 'sendProviderMoveInSaleSchema']);

        /** Sale schema routes **/
        Route::post('send-schema/{leadId}', [SchemaController::class, 'sendSchema']);
    });

    //Affiliates
    Route::prefix('affiliates')->group(function () {
        //Affiliate and Sub Affiliate
        Route::get('list', [AffiliateController::class, 'index'])->name('affiliates.list');
        Route::post('list', [AffiliateController::class, 'index']);
        Route::post('filters', [AffiliateController::class, 'filters']);
        // Route::get('generate-password/{token}', [AffiliateController::class, 'getGeneratePassword']);
        // Route::post('update-password', [AffiliateController::class, 'updatePassword'])->name('affiliates.updatePassword');
        Route::get('create', [AffiliateController::class, 'getCreateUpdate'])->name('affiliates.create');
        Route::post('store', [AffiliateController::class, 'store']);
        Route::get('sub-affiliates/create/{id}', [AffiliateController::class, 'getCreateUpdate'])->name('sub-affiliates.create');
        Route::get('sub-affiliates/edit/{id}', [AffiliateController::class, 'show']);
        Route::get('edit/{id}', [AffiliateController::class, 'show'])->name('affiliates.edit');
        Route::post('status', [AffiliateController::class, 'changeStatus']);
        Route::post('update/{id}', [AffiliateController::class, 'update']);
        Route::get('sub-affiliates/{id}', [AffiliateController::class, 'index'])->name('sub-affiliates.list');
        Route::post('sub-affiliates/{id}', [AffiliateController::class, 'index']);
        Route::post('vertical-status', [AffiliateController::class, 'verticalStatus']);
        Route::post('store-vertical-services', [AffiliateController::class, 'storeVerticalServices']);
        Route::post('delete-vertical', [AffiliateController::class, 'deleteVertical']);
        Route::post('send-reset-password', [AffiliateController::class, 'sendResetPasswordMail']);
        Route::post('updateparameters', [AffiliateController::class, 'updateParameters']);
        Route::post('updateplantype', [AffiliateController::class, 'updatePlanType']);
        Route::post('getserviceparameter', [AffiliateController::class, 'getserviceParameter']);

        //Mange users,providers and distributors
        Route::post('link-users/{id}', [ManageUserController::class, 'index'])->name('link-user');
        Route::post('link-providers/{id}', [ManageUserController::class, 'getProviders'])->name('link-providers');
        Route::post('link-distributors/{id}', [ManageUserController::class, 'getDistributors'])->name('link-distributors');

        Route::post('get-users', [ManageUserController::class, 'getUsers']);
        Route::post('get-providers', [ManageUserController::class, 'getProviderWithRelation']);
        Route::post('change-provider-status', [ManageUserController::class, 'changeProviderStatus']);
        Route::post('get-distributors', [ManageUserController::class, 'getDistributorsWithService']);

        Route::post('deleteuser', [ManageUserController::class, 'deleteUser']);
        Route::post('deleteprovider', [ManageUserController::class, 'deleteProvider']);
        Route::post('deletedistributor', [ManageUserController::class, 'deleteDistributor']);

        Route::post('assign-users', [ManageUserController::class, 'assignUsers']);
        Route::post('assign-providers', [ManageUserController::class, 'assignProviders']);
        Route::post('assign-distributors', [ManageUserController::class, 'assignDistributors']);

        Route::post('get-provider-assigned-plans', [ManageUserController::class, 'getProviderAssignedPlans']);
        Route::post('set-provider-disallow-plans', [ManageUserController::class, 'setProviderDisallowPlans']);

        //Ip whitelist
        Route::post('link-whitelistip', [IpWhitelistController::class, 'index'])->name('link-whitelistip');
        Route::post('assign-whitelistip', [IpWhitelistController::class, 'assignWhitelistIp']);
        Route::post('deletewhitelistips', [IpWhitelistController::class, 'deleteWhiteListIp']);



        Route::get('sub-affiliates/link-users/{id}', [ManageUserController::class, 'index'])->name('sub-affiliates.link-user');
        Route::get('retention-sale/{id}', [AffiliateController::class, 'retentionSale'])->name('retention-sale.list');

        // affiliate templates
        Route::get('templates/{affiliate_id}', [AffiliateTemplateController::class, 'emailTemplates'])->name('templates.list');
        Route::get('/add-template/{affiliate_id}/{source}/{type}/{email_type}/{template_type}', [AffiliateTemplateController::class, 'addEmailTemplate']);
        Route::get('/edit-template/{affiliate_id}/{id}', [AffiliateTemplateController::class, 'addEmailTemplate']);
        Route::post('/get_email_sms_template_data', [AffiliateTemplateController::class, 'getDataEmailSmsTemplate']);
        Route::get('templates/preview/{affiliate_id}/{id}/{sub_affiliate}', [AffiliateController::class, 'getPreview']);
        Route::post('/saveUpdateEmailTemplate', [AffiliateTemplateController::class, 'saveUpdateEmailTemplate']);
        Route::post('/delete_template', [AffiliateTemplateController::class, 'deleteTemplate']);
        Route::post('/addEditCheckRestrict', [AffiliateTemplateController::class, 'addEditRestrict']);
        Route::post('/template-email-status', [AffiliateTemplateController::class, 'emailTemplateStatus']);

        //api key
        //Route::get('affiliate-settings/{id}', [ApikeyController::class, 'index'])->name('affiliate-keys.list');
        Route::match(['get', 'post'], 'affiliate-settings/{id}', [ApikeyController::class, 'index'])->name('affiliate-keys.list');
        Route::get('sub-affiliates/affiliate-settting/{id}', [ApikeyController::class, 'index'])->name('sub-affiliates.affiliate-keys.list');
        Route::post('change-status', [ApikeyController::class, 'changeAffstatusKey'])->name('apikey.changestatus');
        Route::resource('apikey', ApikeyController::class);
        //target
        Route::get('manage-target/{id}', [TargetController::class, 'index'])->name('manage-target.list');
        Route::post('filtertarget/{id}', [TargetController::class, 'index']);
        Route::get('sub-affiliates/manage-target/{id}', [TargetController::class, 'index'])->name('sub-affiliates.manage-target.list');
        Route::get('target-export', [TargetController::class, 'getTargetExport'])->name('affiliate.targetexport');
        Route::resource('managetarget', TargetController::class);
        //tags
        Route::get('manage-tag/{id}', [AffiliateTagsController::class, 'manageTags'])->name('manage-tag.list');
        Route::post('savetags', [AffiliateTagsController::class, 'saveTags'])->name('saveafftags');
        Route::get('tagdetails/{id}', [AffiliateTagsController::class, 'getAffTagsDetail'])->name('tagdetails');
        //matrix
        Route::get('idmatrix/{id}', [MatrixController::class, 'getIdMatrix'])->name('matrix-id.list');
        Route::post('saveidmatrix', [MatrixController::class, 'saveIdMatrix'])->name('saveIdMatrix');
        //retention code
        Route::get('getretention/{id}', [AffiliateRetentionController::class, 'getRetention']);
        Route::get('providerstatus', [AffiliateRetentionController::class, 'getProviderStatusSubaff']);
        Route::get('getassignedproviders', [AffiliateretentionController::class, 'getProvidersByserviceId'])->name('retension.getproviders');
        Route::post('saveretention', [AffiliateretentionController::class, 'SaveRetention'])->name('retension.saveretention');

        Route::post('get-affiliate-bdm', [AssignPermission::class, 'getAffiliateBDM']);
        Route::post('get-service-permissions', [AssignPermission::class, 'getServicePermissions']);
        Route::post('save-permissions', [AssignPermission::class, 'SavePermissions']);
        Route::post('add-affiliate-bdm-form', [AssignPermission::class, 'storeAffiliateBdm']);
        Route::post('update-affiliate-bdm-form/{idVal}', [AssignPermission::class, 'updateAffiliateBdm']);
        Route::get('affiliate-bdm-permissions/{userId}/{id}', [AssignPermission::class, 'getAffiliateBdmPermissions']);
        Route::get('sub-affiliates/affiliate-bdm-permissions/{userId}/{id}', [AssignPermission::class, 'getAffiliateBdmPermissions']);

        // commission
        Route::get('commission/{affiliate_id}', [CommissionController::class, 'getCommission'])->name('affiliates.commission');
        Route::post('ajax-commission/{affiliate_id}/{service_id}', [CommissionController::class, 'getCommissionAjax'])->name('affiliates.ajax-commission');
        Route::post('add-commission/{affiliate_id}/{service_id}', [CommissionController::class, 'addCommission'])->name('affiliates.add-commission');

        Route::post('get-service-permissions', [AssignPermission::class, 'getServicePermissions']);
        Route::post('save-permissions', [AssignPermission::class, 'SavePermissions']);

        //search address
        Route::post('search-address', [SearchAddressController::class, 'searchAddress']);
        Route::get('recon-sale/{id}', [AffiliateReconController::class, 'getRecon'])->name('recon.sale');
        Route::post('generate-recon-file', [AffiliateReconController::class, 'generateReconFile'])->name('recon.generate-recon-file');
    });

    // Sales listing
    Route::prefix('sales')->group(function () {
        Route::get('list', [LeadController::class, 'index'])->name('sales.list');
        Route::post('filter-data', [LeadController::class, 'index']);
        Route::get('detail/{verticalId}/{productId}', [LeadController::class, 'detail'])->name('sales.detail');
        Route::post('resend-welcome-email', [LeadController::class, 'resendWelcomeEmail']);
        Route::get('change-lead-status', [SaleSubmissionController::class, 'postChangeLeadStatus']);
        Route::get('testing-red-and-lumo', [SaleSubmissionController::class, 'postRLSubmission']);
        Route::get('get-qa-list', [LeadController::class, 'getQaList']);
        Route::get('get-api-list', [LeadController::class, 'getAPIList']);
        Route::post('assign-qa', [LeadController::class, 'assginQaTOsale']);
        Route::post('change-status', [LeadController::class, 'changeStatus'])->name('sales.detail');
        Route::post('get-sub-statuses', [LeadController::class, 'getSubStatus']);
        Route::post('get_affiliate_list', [LeadController::class, 'getAffiliateData']);
        Route::post('change_affilitae', [LeadController::class, 'changeAffiliate']);
        Route::post('get-assigned-qa-list', [LeadController::class, 'getAssignedQaList']);
        Route::post('get-affiliate-by-service', [LeadController::class, 'getAffiliateByService']);
        Route::post('get-sub-affiliate-list', [LeadController::class, 'getSubAffiliateList']);
        Route::post('generate-lead-csv', [LeadController::class, 'getGenerateCsv']);
        Route::post('/sale-detail/update-customer-info', [LeadController::class, 'updateCustomerInfoData']);
        Route::post('/customer/update-customer-note', [LeadController::class, 'updateCustomerNote']);
        Route::post('/sale-detail/update-stage', [LeadController::class, 'updateStage']);
        Route::post('/sale-detail/update-journey', [LeadController::class, 'updateJourney']);
        Route::post('/sale-detail/update-address', [LeadController::class, 'updateAddress']);
        Route::post('/sale-detail/update-demand-details-info', [LeadController::class, 'updateDemandDetailsData']);
        Route::post('/sale-detail/update-nmi-number-info', [LeadController::class, 'updateNmiNumbersData']);
        Route::post('/concession/update-concession-details', [LeadController::class, 'updateConcessionDetails']);
        Route::post('/sale-detail/update-site-access-info', [LeadController::class, 'updateSiteAccessData']);
        Route::post('/sale-detail/update-qa-section-info', [LeadController::class, 'updateQaSectionData']);
        Route::post('/identification-detail/update-primary-data', [LeadController::class, 'updatePrimaryIdentification']);
        Route::post('/identification-detail/update-secondary-data', [LeadController::class, 'updateSecondaryIdentification']);
        Route::post('/sale-detail/update-other-info', [LeadController::class, 'updateOtherInfoData']);
        Route::post('/customer/joint-account-update', [LeadController::class, 'jointAccountUpdate']);

        Route::post('/sale-detail/update-id-document', [LeadController::class, 'updateIdentificationDocument']);
        Route::get('/get-sale-update-history/{verticalId}/{section}/{id}', [LeadController::class, 'getSaleUpdateHistory']);
        Route::post('/save-assigned-qa-logs', [LeadController::class, 'assignedQaLogsData']);
    });

    //Manage addons
    Route::prefix('addons')->group(function () {
        Route::get('home-line-connection/list', [AddonsController::class, 'index'])->name('addons.home-line-connection');
        Route::get('add-home-connection/{category}', [AddonsController::class, 'create']);
        Route::get('edit/{category}/{id}', [AddonsController::class, 'edit'])->name('addons.edit');
        Route::post('store/{id}', [AddonsController::class, 'store'])->name('addons.store');
        Route::get('delete/{id}', [AddonsController::class, 'delete'])->name('addons.delete');
        Route::get('modem/list', [AddonsController::class, 'index'])->name('addons.modem');
        Route::get('add-modem/{category}', [AddonsController::class, 'create']);
        Route::get('additional-addons/list', [AddonsController::class, 'index'])->name('addons.additional-addons');
        Route::post('update-status', [AddonsController::class, 'updateStatus']);
        Route::get('add-addon/{category}', [AddonsController::class, 'create']);
        Route::get('get-technology-type/{id}', [AddonsController::class, 'getTechnologyType']);
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('dmovdo', [SettingController::class, 'index']);
        Route::get('tags', [TagsSettingController::class, 'index']);
        Route::post('tags', [TagsSettingController::class, 'index']);
        Route::post('tags/store', [TagsSettingController::class, 'store'])->name('tag.store');
        Route::get('tags/delete/{id}', [TagsSettingController::class, 'deleteTag']);
        Route::post('settings-dmo', [SettingController::class, 'update'])->name('settings.dmovdo');
        Route::get('holiday-calendar', [SettingController::class, 'holidayCalendar']);
        Route::get('national-holidays', [SettingController::class, 'getNationalHolidays'])->name('national.holidays');
        Route::post('save-national-holidays', [SettingController::class, 'saveNationalHolidays']);
        Route::get('state-holidays', [SettingController::class, 'getStateHolidays']);
        Route::get('get-calendar-events', [SettingController::class, 'getCalendarEvents']);
        Route::post('save-state-holidays', [SettingController::class, 'saveStateHolidays']);
        Route::post('weekend-content', [SettingController::class, 'getWeekendContent']);
        Route::post('closing-time', [SettingController::class, 'getClosingTime']);
        Route::post('delete-national-holiday', [SettingController::class, 'deleteNationalHoliday']);
        Route::post('delete-state-holiday', [SettingController::class, 'deleteStateHoliday']);

        Route::get('master-settings', [MasterSettingController::class, 'getSettings'])->name('settings.master.settings');

        Route::post('master-settings/import-demand-tariff', [ImportTariffRateController::class, 'postImportDemandTarrif'])->name('settings.master.settings.import.demand');

        Route::post('master-settings/get-demand-tariff-sample', [ImportTariffRateController::class, 'getDemandTarrif'])->name('settings.master.settings.get.demand.sample');

        Route::get('master-settings/get-master-tariff-ids', [ImportTariffRateController::class, 'genrateTariffIds'])->name('settings.master.settings.get.tarridId');

        Route::post('saveidmatrix', [SettingController::class, 'saveIdMatrix'])->name('settings.master-settings.saveIdMatrix');

        Route::get('get-idmatrix', [SettingController::class, 'getIdMatrix'])->name('settings.master-settings.getIdMatrix');

        Route::get('life-support-equipments', [LifeSupportEquipmentController::class, 'index']);
        Route::get('get-life-support-equipments', [LifeSupportEquipmentController::class, 'getLifeSupportData']);
        Route::get('change-life-support-status/{life_support_id}', [LifeSupportEquipmentController::class, 'changeLifeSupportEquipmentStatus']);
        Route::delete('delete-life-support-equipment/{life_support_id}', [LifeSupportEquipmentController::class, 'deleteLifeSupportEquipment']);
        Route::post('post-life-support-equipments/{life_support_id?}', [LifeSupportEquipmentController::class, 'addUpdate']);
        Route::post('post-master-life-support-content', [LifeSupportEquipmentController::class, 'postMasterLifeSupportContent']);

        Route::get('dmovdo-prices', [DmoVdoController::class, 'index']);
        Route::post('get-dmo-vdo', [DmoVdoController::class, 'getDmoVdo']);
        Route::post('post-dmo-vdo/{dmo_vdo_id?}', [DmoVdoController::class, 'postDmoVdo']);
        Route::post('import-dmo-vdo', [DmoVdoController::class, 'importDmoVdo']);
        Route::post('post-dmo-vdo-states', [DmoVdoController::class, 'postDmoVdoStates']);
        Route::get('download-dmo-vdo-sample-sheet', [DmoVdoController::class, 'downloadDmoVdoSampleSheet']);
        Route::delete('delete-dmo-vdo/{dmo_vdo_id}', [DmoVdoController::class, 'deleteDmoVdo']);

        // master tariff codes
        Route::get('master-tariff-codes', [MasterTariffCodeController::class, 'index']);
        Route::post('get-master-tariff-codes', [MasterTariffCodeController::class, 'getMasterTariffCode']);
        Route::get('change-master-tariff-codes-status/{master_tariff_code_id}', [MasterTariffCodeController::class, 'changeMasterTariffCodeStatus']);
        Route::post('change-master-tariff-codes-status-bulk', [MasterTariffCodeController::class, 'changeMasterTariffCodeStatusBulk']);
        Route::post('post-master-tariff-codes/{master_tariff_code_id?}', [MasterTariffCodeController::class, 'postMasterTariffCode']);
        Route::post('import-master-tariff-codes', [MasterTariffCodeController::class, 'importMasterTariffCode']);
        Route::get('download-master-tariff-codes-sample-sheet', [MasterTariffCodeController::class, 'downloadMasterTariffCodeSampleSheet']);
        Route::delete('delete-master-tariff-codes/{master_tariff_code_id}', [MasterTariffCodeController::class, 'deleteMasterTariffCode']);

        // distributors
        Route::get('distributors', [DistributorController::class, 'index']);
        Route::post('get-distributors', [DistributorController::class, 'getDistributor']);
        Route::get('change-distributors-status/{distributor_id}', [DistributorController::class, 'changeDistributorStatus']);
        Route::post('post-distributors', [DistributorController::class, 'postDistributor']);
        Route::get('download-post-codes-sample-sheet', [DistributorController::class, 'downloadPostCodesSampleSheet']);
        Route::delete('delete-distributors/{distributor_id}', [DistributorController::class, 'deleteDistributor']);

        // post codes
        Route::get('get-post-codes', [DistributorController::class, 'getPostCodes']);
        Route::get('get-distributor-post-codes/{distributor_id}', [DistributorController::class, 'getDistributorPostCodes']);
        Route::post('import-distributor-post-codes', [DistributorController::class, 'importDistributorPostCodes']);

        // Dialler Ignore Data
        Route::any('dialler-ignore-data', [DiallerIgnoreDataController::class, 'index']);
        Route::post('add/dialler-ignore', [DiallerIgnoreDataController::class, 'create']);
        Route::post('delete/dialler-ignore', [DiallerIgnoreDataController::class, 'destroy']);
        Route::post('search/dialler-data', [DiallerIgnoreDataController::class, 'search']);
    });

    // Reports
    Route::prefix('reports')->group(function () {
        Route::match(['get', 'post'], 'sales-qa-logs', [SalesQaReportController::class, 'index']);
        Route::post('sales-qa-logs/search', [SalesQaReportController::class, 'show']);
    });
    // Usage
    Route::prefix('usage')->group(function () {
        Route::get('setlimits', [SetlimtsController::class, 'index']);
        Route::post('create', [SetlimtsController::class, 'store']);
        Route::post('update', [SetlimtsController::class, 'updateUsage']);
        Route::post('getdatausagetype', [SetlimtsController::class, 'searchUsageData']);
    });
    // Usage
    Route::prefix('mobile')->group(function () {
        // brand
        Route::post('filterbrand', [BrandsController::class, 'index']);
        Route::post('change-status', [BrandsController::class, 'changeBrandstatus'])->name('brand.changestatus');
        Route::resource('managebrand', BrandsController::class);
        // ram
        Route::post('filter-ram', [RamController::class, 'index']);
        Route::post('change-ram-status', [RamController::class, 'changeRamstatus'])->name('ram.changestatus');
        Route::resource('manageram', RamController::class);
        // storage
        Route::post('filter-storage', [StorageController::class, 'index']);
        Route::post('change-storage-status', [StorageController::class, 'changeStoragestatus'])->name('storage.changestatus');
        Route::resource('managestorage', StorageController::class);

        // handsets
        Route::match(['get', 'post'], 'handsets', [MobileHandsetsController::class, 'index']);
        Route::get('get-phone-form/{id?}', [MobileHandsetsController::class, 'getCreateOrEdit']);
        Route::post('/save', [MobileHandsetsController::class, 'storePhone']);
        Route::put('/save/{phoneId}', [MobileHandsetsController::class, 'updatePhone']);
        Route::delete('delete/{id}', [MobileHandsetsController::class, 'deletePhone']);
        Route::post('change-handset-status', [MobileHandsetsController::class, 'changeHandsetStatus']);
        Route::post('change-handset-status/accepted', [MobileHandsetsController::class, 'changeStatusAccepted']);
        Route::post('/check-assign-provider', [MobileHandsetsController::class, 'checkAssignProvider']);
        Route::post('/handset/assign-provider', [MobileHandsetsController::class, 'assignProvider']);

        // colors
        Route::post('filter-colors', [ColorsController::class, 'index']);
        Route::post('change-colors-status', [ColorsController::class, 'changeColorstatus'])->name('colors.changestatus');
        Route::resource('managecolors', ColorsController::class);

        // contract
        Route::post('filter-contract', [ContractController::class, 'index']);
        Route::post('change-contract-status', [ContractController::class, 'changeContractstatus'])->name('contract.changestatus');
        Route::resource('managecontract', ContractController::class);

        Route::post('store', [MobileHandsetsController::class, 'storePhone']);
        Route::get('list-variant/{id}', [VariantController::class, 'index']);
        Route::get('add-variant/{id}', [VariantController::class, 'addVariant'])->name('add-variant');
        Route::post('store-variant', [VariantController::class, 'store'])->name('store-variant');
        Route::post('update-variant-status', [VariantController::class, 'updateStatus']);
        Route::get('edit-variant/{id}/{variantid}', [VariantController::class, 'editVariant'])->name('edit.variant');
        Route::post('update-variant', [VariantController::class, 'updateVariant'])->name('update-variant');
        Route::get('variant-images-delete/{id}', [VariantController::class, 'deleteVariantimage']);
        Route::post('list-variant', [VariantController::class, 'index']);
        Route::post('/variants/check-assign-provider', [VariantController::class, 'checkAssignProvider']);
        Route::post('/variants/assign-provider', [VariantController::class, 'assignProvider']);
    });


    // Usage
    Route::prefix('reconsettings')->group(function () {
        Route::get('listing', [ReconController::class, 'index']);
        Route::post('getsubaffiliates', [ReconController::class, 'getSubaffiliates']);
        Route::post('addreconpermission', [ReconController::class, 'addReonPermission']);
        Route::post('managerecon', [ReconController::class, 'manageRecon']);
        Route::post('listing', [ReconController::class, 'index']);
    });

    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });

    //Affiliates
    Route::prefix('manage-user')->group(function () {
        //Affiliate and Sub Affiliate
        Route::get('list', [UserController::class, 'index']);
        Route::post('list', [UserController::class, 'index']);
        Route::post('add', [UserController::class, 'store']);
        Route::post('update/{idVal}', [UserController::class, 'update']);
        Route::get('assign-affiliate/{idVal}', [UserController::class, 'getLinkUser']);
        Route::post('assign-affiliate/{idVal}', [UserController::class, 'postLinkUser']);
        Route::post('get-sub-affiliate', [UserController::class, 'getSubAffiliates']);

        Route::get('assign-permissions/{idVal}', [UserController::class, 'getPermissions']);
        Route::post('assign-permissions/{id}', [UserController::class, 'postPermissions']);

        Route::post('get-template-permission', [UserController::class, 'getTemplatePermissions']);
    });


    //Affiliates
    Route::prefix('statistics')->group(function () {
        Route::get('view', [ManageStatisticController::class, 'index']);
        Route::post('/get-connection-graph', [ManageStatisticController::class, 'getData']);
        Route::post('get-affiliates-by-service', [ManageStatisticController::class, 'getAffiliateByService']);
        Route::post('get-subaffiliate', [ManageStatisticController::class, 'getSubAffiliateList']);
        Route::post('get-conversion-graph', [ManageStatisticController::class, 'getConversionGraphData']);
        Route::post('get-comparison-graph', [ManageStatisticController::class, 'getComparisonGraphData']);
        Route::get('get-top-worst-plans', [ManageStatisticController::class, 'getTopWorstPlans']);
    });
    Route::prefix('settings')->group(function () {
        Route::get('export-settings', [ExportSettingsController::class, 'index']);
        Route::post('change-password',[ExportSettingsController::class,'resetLeadSaleExportPassword']);
    });

});

Route::resource('users', UsersController::class);

/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__ . '/auth.php';
