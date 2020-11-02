<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = City::paginate(100);

        return response([
            'success' => true,
            'message' => 'List of All Posts',
            'data' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'address'   => 'required',
        ],
            [
                'name.required' => 'Enter Title Post! ',
                'address.required' => 'Enter body Post !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                            'success' => false,
                            'message' => 'Please fill in the blank fields',
                            'data'    => $validator->errors()
                        ],400);
        
        }
        
        $post =new City;
        $post->name = $request->name;
        $post->address = $request->address;

        $post->save();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post Failed to Save!',
            ], 500);  
        } 
                    
        return response()->json([
            'success' => true,
            'message' => 'Post Saved Saved! ',
        ], 200);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = City::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post Not Found!',
                'data'    => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Post!',
            'data'    => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate data
       
        $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'address'   => 'required',
            ],
            [
                'name.required' => 'Enter Title of the Post!',
                'address.required' => 'Enter description of the Post !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                        'success' => false,
                        'message' => 'Please fill in the blank fields',
                        'data'    => $validator->errors()
                    ], 400);
        }
        
       
        $post = City::whereId($id)->update([
                        'name'     => $request->input('name'),
                        'address'   => $request->input('address'),
                    ]);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post Failed to Update!',
            ], 500); 
        }

        return response()->json([
            'success' => true,
            'message' => 'Post Updated successfully!',
        ], 200);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = City::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post Failed to Delete!',
            ], 500);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post Successfully Deleted!',
        ], 200);
    }
}
