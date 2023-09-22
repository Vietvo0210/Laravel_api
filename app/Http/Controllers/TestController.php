<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function retrieveDetail($id)
    {
        return Test::where('id', $id)->exists();
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
                $test = Test::query()->limit((int)$param["limit"])->get();
            } else $test = Test::query()->get();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($test);
    }

    public function show($id)
    {
        try {
            $product = Test::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($product);
    }

    public function store(Request $request)
    {
        try {
            $product = Test::create($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->result($product);
    }

    public function update(Request $request, $id)
    {
        try {
            if($this->retrieveDetail($id)) {
                $product = Test::find($id);
                $product->name = is_null($request->name) ? $product->name : $request->name;
                $product->save();
            }
        }catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'message' => 'Product updated'
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        try {
            if($this->retrieveDetail($id)) {
                $product = Test::find($id);
                $product->delete();
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
        if(array_key_exists("name", $param)){
            return Test::query()->where('name', '=', $param["name"])->limit($limit)->get();
        }
        return Test::query()->get();
    }
}
