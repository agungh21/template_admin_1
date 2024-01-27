<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\Setting;
use App\MyClass\Response;
use App\MyClass\Validations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    // -------------
    // DASHBOARD
    // -------------
    public function index()
    {
        $settings = Setting::getSettingCommon();

        $users = User::where('role', User::ROLE_USER)->count();

        return view('admin.index', [
            'title' => 'Dashboard',
            'settings' => $settings,
            'users' => $users,
        ]);
    }

    // -------------
    // USER
    // -------------
    public function userIndex(Request $request)
    {
        $settings = Setting::getSettingCommon();
        if ($request->ajax()) {
            return User::dt();
        }
        return view('admin.user.index', [
            'title' => 'User',
            'settings' => $settings,
        ]);
    }

    public function userStore(Request $request, User $user)
    {

        Validations::userValidation($request);

        DB::beginTransaction();

        try {
            $user->createUser([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            DB::commit();
            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function userUpdate(Request $request, User $user)
    {
        Validations::userEditValidation($request, $user->id);
        DB::beginTransaction();

        try {
            $user->updateUser($request->except(['password', 'confirm_password']));

            if(!empty($request->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function userDestroy(User $user)
    {
        DB::beginTransaction();

        try {
            $user->deleteUser();
            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function userGet(User $user)
    {
        try {
			return Response::success([
				'user' => $user
			]);
		} catch (\Exception $e) {
			return Response::error($e);
		}
    }

    // ---------------
    // Pengaturan Umum
    // ---------------
    public function settingCommonIndex()
    {
        $title = "Umum";
        $settings = Setting::getSettingCommon();

        return view('admin.setting.common', [
            'title'            => $title,
            'settings'         => $settings,
            'breadcrumbs' => [
                [
                    'title' => "Dashboard",
                    'link'  => route('admin'),
                ],
                [
                    'title' => $title,
                    'link'  => route('admin.setting.common'),
                ],
            ],
        ]);
    }

    public function settingCommonStore(Request $request)
    {

        DB::beginTransaction();

        try {
            $requestAll = $request->all();

            Setting::commonStore($requestAll);

            DB::commit();

            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    // -------------
    // Campaign
    // -------------
    public function campaignIndex(Request $request)
    {
        $settings = Setting::getSettingCommon();
        if ($request->ajax()) {
            return Campaign::dt();
        }
        return view('admin.campaign.index', [
            'title' => 'Campaign',
            'settings' => $settings,
        ]);
    }

    public function campaignStore(Request $request, Campaign $campaign)
    {

        Validations::campaignValidation($request);

        DB::beginTransaction();

        try {

            $campaign->createCampaign($request->all());

            DB::commit();
            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function campaignUpdate(Request $request, Campaign $campaign)
    {
        Validations::campaignEditValidation($request, $campaign->id);
        DB::beginTransaction();

        try {

            $campaign->updateCampaign($request->all());

            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function campaignDestroy(Campaign $campaign)
    {
        DB::beginTransaction();

        try {

            $campaign->deleteCampaign();
            $campaign->campaignTargetsDelete();

            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function campaignGet(Campaign $campaign)
    {
        try {
			return Response::success([
				'campaign' => $campaign
			]);
		} catch (\Exception $e) {
			return Response::error($e);
		}
    }

    // -------------
    // Campaign Target
    // -------------
    public function campaignTargetIndex(Request $request)
    {
        $campaigns = Campaign::all()->sortBy('campaign_name');
        $settings = Setting::getSettingCommon();
        if ($request->ajax()) {
            return CampaignTarget::dt();
        }
        return view('admin.campaign-target.index', [
            'title' => 'Campaign Target',
            'settings' => $settings,
            'campaigns' => $campaigns,
        ]);
    }

    public function campaignTargetStore(Request $request, CampaignTarget $campaignTarget)
    {

        Validations::campaignTargetValidation($request);

        DB::beginTransaction();

        try {

            $campaignTarget->createCampaignTarget($request);
            Campaign::countTotal();

            DB::commit();
            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function campaignTargetDestroy(CampaignTarget $campaignTarget)
    {
        DB::beginTransaction();

        try {

            $campaignTarget->deleteCampaignTarget();

            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function campaignTargetTemplateImport($filename)
	{
		try {
			$path = storage_path('app/public/docs/'.$filename);
			return response()->download($path);
		} catch (\Exception $e) {
			return \Res::error($e);
		}
	}


}
