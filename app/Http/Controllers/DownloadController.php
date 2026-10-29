<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class DownloadController extends Controller
{
  public function download(Request $request)
  {
  	$filename = $request->filename;
  	if ($filename == "soal") {
  		$file = file_exists(public_path() . "/file/soal.xlsx") ? (public_path() . "/file/soal.xlsx") : (public_path() . "/file/soal.xls");
	    $headers = array(
			  'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			  'Content-Disposition' => 'attachment; filename=format_template_soal.xlsx',
			);
			if ( file_exists( $file ) ) {
        return Response::download($file, 'format_template_soal.xlsx', $headers);
      } else {
        exit( 'Requested file does not exist on our server!' );
      }
  	}
    if ($filename == "siswa") {
      $file = public_path(). "/file/siswa.xls";
      $headers = array(
        'Content-Type' => 'application/csv',
        'Content-Disposition' => 'attachment; filename=' . $filename,
      );
      if ( file_exists( $file ) ) {
        // Send Download
        return Response::download($file, 'format_siswa.xls', $headers);
      } else {
        // Error
        exit( 'Requested file does not exist on our server!' );
      }
    }
  }
}
