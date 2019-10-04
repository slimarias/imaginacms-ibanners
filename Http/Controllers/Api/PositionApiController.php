<?php

namespace Modules\Ibanners\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Ibanners\Repositories\Eloquent\EloquentPositionApiRepository;
use Modules\Ibanners\Repositories\PositionApiRepository;
use Modules\Ibanners\Services\SlideOrderer;
use Modules\Ibanners\Transformers\PositionApiTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PositionApiController extends BaseApiController
{
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var SlideOrderer
     */
    private $bannerOrderer;
    /**
     * @var EloquentPositionApiRepository
     */
    private $position;

    public function __construct(PositionApiRepository $position, SlideOrderer $bannerOrderer)
    {
        $this->position = $position;
        $this->bannerOrderer = $bannerOrderer;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $positions = $this->position->getItemsBy($params);

            //Response
            $response = [
                "data" => PositionApiTransformer::collection($positions)
            ];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($positions)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * Show banner by id
     */
    public function show($id, Request $request)
    {
        try {
            //Request to Repository

            $params = $this->getParamsRequest($request, []);
            $position = $this->position->show($id, $params->include);

            //Response
            $response = [
                "data" => is_null($position) ?
                    false : new PositionApiTransformer($position)
            ];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            // $this->validateRequestApi(new CustomRequest((array)$data));

            //Create item
            $this->position->create($data);

            //Response
            $response = ["data" => ""];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdatePositionRequest((array)$data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            $dataEntity = $this->position->getItem($criteria, $params);

            if (!$dataEntity) throw new Exception('Item not found', 204);

            //Request to Repository
            $this->position->update($dataEntity, $data);


            if (isset($data["banners"])) {
                $this->bannerOrderer->handle(json_encode($data["banners"]));
            }

            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->position->getItem($criteria, $params);

            if (!$dataEntity) throw new Exception('Item not found', 204);
            $this->position->delete($dataEntity);

            //Response
            $response = ["data" => ""];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

}
