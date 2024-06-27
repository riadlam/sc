<?php

namespace App\Actions\Tenant;

use App\Helpers\FlashMsg;
use Modules\DigitalProduct\Entities\DigitalProductDownload;

class ZipFileDownloader
{
    public string $zip_file_location;
    public function __destruct()
    {

    }

    public function download($product)
    {
        $zip_file_name = time().'.zip';
        $this->zip_file_location = global_assets_path('assets/tenant/uploads/digital-product-file/'.tenant()->id.'/'.$zip_file_name);
        $zip_file_location = $this->zip_file_location;

        $zip = new \ZipArchive();

        if ($zip->open($zip_file_location, \ZipArchive::CREATE) === TRUE)
        {
            $real_file_path = global_assets_path('assets/tenant/uploads/digital-product-file/'.tenant()->id.'/'.$product->file);

            if (!is_dir($real_file_path) && file_exists($real_file_path) && is_file($real_file_path))
            {
                $zip->addFile($real_file_path, $product->file);
                $zip->close();
            } else {
                return back()->with(FlashMsg::explain('error', 'No file exists'));
            }
        }

        $digital_download = DigitalProductDownload::where(['product_id' => $product->id, 'user_id' => auth('web')->user()->id])->first();
        $digital_download->increment('download_count');
        $digital_download->save();

        return response()->download($zip_file_location)->deleteFileAfterSend();
    }
}
