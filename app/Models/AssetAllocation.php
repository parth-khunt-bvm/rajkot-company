<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $table = "asset_allocation";

    public function saveAdd($requestData)
    {
        foreach ($requestData['asset_master_id'] as $assetkey => $value) {
            $objAssetAllocation = new AssetAllocation();
            $objAssetAllocation->employee_id = $requestData['employee_id'];
            $objAssetAllocation->asset_id = $value;
            $objAssetAllocation->created_at = date('Y-m-d H:i:s');
            $objAssetAllocation->updated_at = date('Y-m-d H:i:s');
            if ($objAssetAllocation->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Asset Allocation');
            }
        }
        return 'added';
    }

}
