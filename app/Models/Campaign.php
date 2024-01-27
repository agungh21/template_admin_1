<?php

namespace App\Models;

use App\MyClass\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaignTargets(){
        return $this->hasMany(CampaignTarget::class, 'id_campaign', 'id');
    }

    public static function createCampaign(array $request)
    {
        $campaign = self::create($request);
        $campaign->update([
            'id_user' => auth()->user()->id,
        ]);

        return $campaign;
    }

    public function updateCampaign(array $request)
    {
        $this->update($request);
        $this->update([
            'id_user' => auth()->user()->id,
        ]);

        return $this;
    }

    public function deleteCampaign()
    {
        return $this->delete();
    }

    public function campaignTargetsDelete(){
        return $this->campaignTargets()->delete();
    }

    public static function countTotal(){

        $campaigns = self::all();
        foreach ($campaigns as $key => $campaign) {
            $totalTarget = $campaign->campaignTargets()->count();
            if($totalTarget != $campaign->total_target) {
                $campaign->update(['total_target' => $totalTarget]);
            }

            $totalSent = $campaign->campaignTargets()->where('status', 'sent')->count();
            if($totalSent != $campaign->total_sent) {
                $campaign->update(['total_sent' => $totalSent]);
            }
        }
    }

    public static function createCampaignImport($request) {

        $campaign = self::createCampaign($request->all());
        $idCampaign = $campaign->id;

        $amount = 0;

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
                                'id_campaign'=> $idCampaign,
                                'name'=> $row[0],
                                'phone_number'=> Helper::idPhoneNumberFormat($row[1]),
                                'status'=> 'Panding',
                            ]);
                            $amount++;
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
					}
				}
			}

			\File::delete($path);
		}

		return $amount;
    }

    public static function dt()
    {
        $data = self::where('created_at', '!=', NULL);
        return \Datatables::eloquent($data)
            ->editColumn('action', function ($data) {

                $action = '
                    <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item mr-1 text-primary edit" href="javascript:void(0);" data-edit-href="' . route('admin.campaign.update', $data->id) . '" data-get-href="' . route('admin.campaign.get', $data->id) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        </li>
                        <li>
                            <a class="dropdown-item mr-1 delete text-danger" href="javascript:void(0);" data-delete-message="Yakin ingin menghapus?" data-delete-href="' . route('admin.campaign.destroy', $data->id) . '"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                        </li>
                    </ul>
                    </div>
                ';

                return $action;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

}
