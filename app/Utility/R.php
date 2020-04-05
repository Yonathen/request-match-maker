<?php 
namespace App\Utility;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Enums\ReturnType as ReturnTypeEnum;

trait R
{
	/** @var int */
	public $returnType = ReturnTypeEnum::SINGLE;

	/** @var string */
	public $type;

	/** @var bool */
	public $status = true;

	/** @var T|null|array */
	public $returnValue; 

	/** @var string|null */
	public $errorMessage; 

    public function getResponse()
    {
        $additional = [ 'type' => $this->type, 'status' => $this->status];
        $response = new ResponseResource(null);
        if ($additional['status'] && $this->returnType === ReturnTypeEnum::COLLECTION) {
            $response = new ResponseCollection($this->returnValue);
        } elseif ($additional['status']  && $this->returnType === ReturnTypeEnum::SINGLE) {
            $response = new ResponseResource($this->returnValue);
        } else {
            $additional['errorMessage'] = $this->errorMessage;
        }
        return $response->additional($additional);
    }

    public function failedRequest(Exception $e)
    {
        $this->status = false;
        $this->returnType = null;
        $this->errorMessage = $e->getMessage();
    }
}