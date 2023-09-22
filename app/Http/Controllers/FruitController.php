<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class FruitController extends BaseController
{
    public function retrieveDetail($id)
    {
        return Fruit::where('id', $id)->exists();
    }

    public function result($data)
    {
        return response()->json([
            'data' => $data,
            'message' => 'Success!'
        ], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $param = $request->all();
        try {
            if(array_key_exists("limit", $param)) {
                $fruit = Fruit::query()->limit((int)$param["limit"])->get();
            } else $fruit = Fruit::query()->get();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($fruit);
    }

    public function show($id)
    {
        try {
            $fruit = Fruit::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($fruit);
    }

    public function store(Request $request)
    {
        try {
            $fruit = Fruit::create($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($fruit);
    }

    public function update(Request $request, $id)
    {
        try {
            if($this->retrieveDetail($id)) {
                $fruit = Fruit::find($id);
                $fruit->name = is_null($request->name) ? $fruit->name : $request->name;
                $fruit->type = is_null($request->type) ? $fruit->type : $request->type;
                $fruit->season = is_null($request->type) ? $fruit->season : $request->season;
                $fruit->amount = is_null($request->amount) ? $fruit->amount : $request->amount;
                $fruit->save();
            }
        }catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'message' => 'Fruit updated'
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        try {
            if($this->retrieveDetail($id)) {
                $fruit = Fruit::find($id);
                $fruit->delete();
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->result('');
    }

    public function search(Request $request)
    {
        $param = $request->all();
        $limit = array_key_exists("limit", $param) ? $param["limit"] : 10;
        // Search name
        if(array_key_exists("name", $param)){
            return Fruit::query()->where('name', '=', $param["name"])->limit($limit)->get();
        }
        // Search type
        if(array_key_exists("type", $param)){
            return Fruit::query()->where('type', '=', $param["type"])->limit($limit)->get();
        }
        // Search season
        if(array_key_exists("season", $param)){
            return Fruit::query()->where('season', '=', $param["season"])->limit($limit)->get();
        }
        return Fruit::query()->get();
    }
}
