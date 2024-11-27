<?php

namespace App\Imports;

use App\Models\SocialMediaPost;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SocialMediaPostImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (SocialMediaPost::where('date', date('Y-m-d', strtotime($this->transformDate($row[0]))))->where('is_deleted', 'N')->count() == 0) {
            $objSocialMediaPost = new SocialMediaPost();
            $objSocialMediaPost->date = $this->transformDate($row[0]);
            $objSocialMediaPost->post_detail = $row[1];
            $objSocialMediaPost->note = $row[2] ?? '-';
            $objSocialMediaPost->is_deleted = 'N';
            $objSocialMediaPost->created_at = date('Y-m-d H:i:s');
            $objSocialMediaPost->updated_at = date('Y-m-d H:i:s');
            $objSocialMediaPost->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
