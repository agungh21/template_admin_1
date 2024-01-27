<?php

namespace App\Models;

use App\MyClass\Helper;
use App\MyClass\Whatsapp;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignTarget extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaign(){
        return $this->belongsTo(Campaign::class, 'id_campaign', 'id');
    }

    public static function createCampaignTarget($request)
    {

		if(!empty($request->file_excel))
		{
			$file = $request->file('file_excel');
			$filename = date('YmdHis_').rand(100,999).'.'.$file->getClientOriginalExtension();
			$file->move(storage_path('app/public/temp_files'), $filename);
			$path = storage_path('app/public/temp_files/'.$filename);
			$parseData = \App\MyClass\SimpleXLSX::parse($path);

			if($parseData)
			{
				$iter = 0;
				foreach($parseData->rows() as $row)
				{
					$iter++;
					if($iter == 1) continue;

					if(!empty($row[0])) {
                        DB::beginTransaction();
                        try {
                            CampaignTarget::create([
                                'id_campaign'=> $request->id_campaign,
                                'name'=> $row[0],
                                'phone_number'=> Helper::idPhoneNumberFormat($row[1]),
                                'status'=> 'Pending',
                            ]);
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
					}
				}
			}

			\File::delete($path);
		}
    }

    public function updateCampaignTarget(array $request)
    {
        $this->update($request);

        return $this;
    }

    public function deleteCampaignTarget()
    {
        $this->campaign->countTotal();
        return $this->delete();
    }

    public static function sendMessage($message, $phoneNumber){
        Whatsapp::sendChat([
            'to'	=> $phoneNumber,
            'text'	=> $message
        ]);
    }

    public static function sendBroadcast(){
        $campaignTargets = CampaignTarget::where('status', 'Pending')->get()->take(5);

        foreach($campaignTargets as $campaignTarget){
            $campaignTarget->status = 'Sending';
            $campaignTarget->save();

            $message = str_replace('{name}', $campaignTarget->name, $campaignTarget->campaign->message);
            $phoneNumber = $campaignTarget->phone_number;

            self::sendMessage($message, $phoneNumber);

            $campaignTarget->status = 'Sent';
            $campaignTarget->save();
        }

        Campaign::countTotal();
    }

    public function getStatus(){
        if($this->status == 'Pending') return '<span class="badge bg-warning">Peding</span>';
        if($this->status == 'Sent') return '<span class="badge bg-success">Sent</span>';
        if($this->status == 'Received') return '<span class="badge bg-info">Received</span>';
        if($this->status == 'Read') return '<span class="badge bg-primary">Read</span>';
        if($this->status == 'Sending') return '<span class="badge bg-danger">Sending</span>';
    }

    public function getCampaignName(){
        return $this->campaign->campaign_name ?? '-';
    }

    public static function dt()
    {
        $data = self::select(['campaign_targets.*'])
                        ->leftJoin('campaigns', 'campaigns.id', '=', 'campaign_targets.id_campaign')
                        ->orderBy('created_at', 'desc');

        return \Datatables::eloquent($data)
            ->editColumn('action', function ($data) {

                $action = '
                    <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item mr-1 delete text-danger" href="javascript:void(0);" data-delete-message="Yakin ingin menghapus?" data-delete-href="' . route('admin.campaign_target.destroy', $data->id) . '"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                        </li>
                    </ul>
                    </div>
                ';

                return $action;
            })

            ->editColumn('campaign.campaign_name', function ($data) {
                return $data->getCampaignName();
            })

            ->editColumn('status', function ($data) {
                return $data->getStatus();
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
