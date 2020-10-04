<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Carbon\Carbon;

use App\model\User;
use App\model\RequestTrader;

use App\Enums\FileOperationType;
use App\Enums\FileLocations;
use App\Enums\FileMimeType;

use App\Repositories\Interfaces\FileRepositoryInterface;

class FileRepository implements FileRepositoryInterface
{

	/**
	 * @param string $directoryName
     */
	public function getAllDirectory( $directoryName ) {
		return Storage::allDirectories($directoryName);
	}

	/**
	 * @param string $directoryName
     */
	public function createDirectory( $directoryName ) {
		return Storage::makeDirectory($directoryName);
	}

	/**
	 * @param string $directoryName
     */
	public function deleteDirectory( $directoryName ) {
		return Storage::deleteDirectory($directoryName);
	}

	/**
	 * @param string $directoryName
     */
	public function getAllFiles ( $directoryName ) {
		return Storage::files($directoryName);
	}

	/**
	 * @param string $fileName
     */
	public function getFile ( $fileName ) {
		$result = [ 'status' => true, 'content' => null ];
		try {
			$result['content'] = Storage::get($fileName);
		} catch ( FileNotFoundException $e ) {
			$result['status'] = false;
			$result['content'] = $e;
		}

		return $result;
	}


	/**
	 * @param array|string $fileNameorNames
     */
	public function deleteFileOrFiles ( $fileNameorNames ) {
		return Storage::delete($fileNameorNames);
	}

	public function upload( $files, $location, $fileType = FileMimeType::ALL, $operationType = FileOperationType::SINGLE) {
		$result = [ 'status' => true, 'content' => null ];
		if ( $operationType === FileOperationType::SINGLE) {
			$result = $this->putFile($location, $files, $fileType);
		} elseif ( $operationType === FileOperationType::MULTIPLE) {

			$paths = [];
			foreach ( $files as $file ) {
				$putResult = $this->putFile($location, $files);
				if ( !$putResult['status'] ) {
					$result = $putResult;
					break;
				}
				array_push($paths, $putResult['content'], $fileType);
			}

			if ( $result['status'] ) {
				$result['content'] = $paths;
			}
		}
		return $result;

    }

    public function fileUploadCroppedImage($croppedImage, $location, $name, $imageType) {
        $result = [ 'status' => true, 'content' => null ];

        list($type, $croppedImage) = explode(';', $croppedImage);
        list(, $croppedImage) = explode(',', $croppedImage);
        $croppedImage = base64_decode($croppedImage);
        $imageName = $location. '/' .$name. '_' . time() . '.'.$imageType;
        $uploaded = Storage::disk('local')->put($imageName, $croppedImage);
        if ( $uploaded ) {
            $result['content'] = Storage::url($imageName);
        } else {
            $result = false;
            $result['content'] = "Failed to upload";
        }

        return $result;
    }

	/**
	 * @param  array  $data
	 * @param  string  $type
     */
    public function validator($file, $type)
    {

        return Validator::make([
			'file' => $file
		], [
			'file' => ['required', $type],
        ]);
	}

	public function putFile($location, $file, $type)
	{
		$result = [ 'status' => true, 'content' => null ];
		try {
			$validator = $this->validator($file, $type);
			if ( $validator->fails() ) {
                throw (new Exception($validator->errors(), 1));
			}

			$result['content'] = Storage::putFile($location, $file);
			if ( !$result['content'] ) {
				throw (new Exception("Failed to upload", 1));
			}
		} catch ( Exception $e ) {
			$result['status'] = false;
			$result['content'] = $e;
		}
		return $result;
	}

}
