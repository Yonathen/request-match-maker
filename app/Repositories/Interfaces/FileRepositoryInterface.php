<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestTrader;

interface FileRepositoryInterface
{
	
	public function getAllDirectory( $directoryName );

	public function createDirectory( $directoryName );

	public function deleteDirectory( $directoryName );

	public function getAllFiles ( $directoryName );

	public function getFile ( $fileName );
	
	public function deleteFileOrFiles ( $fileNameorNames );
	
	public function upload( $files, $location, $fileType = FileMimeType::ALL, $operationType = FileOperationType::SINGLE);

    function validator($file, $type);

	function putFile($location, $file, $type);

}
