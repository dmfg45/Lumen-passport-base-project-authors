<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use \Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *
     * @return  Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * @return \Illuminate\Http\Response
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
           'name' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'country' => 'required|max:50'
        ];
        $this->validate($request, $rules);
        $author = Author::create($request->all());
        return $this->successResponse($author,Response::HTTP_CREATED);
    }

    /**
     *
     * @return  Illuminate\Http\Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     *
     * @return  Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'in:male,female',
            'country' => 'max:50'
        ];
        $this->validate($request,$rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());

        if ($author->isClean()){
            return $this->errorResponse('Must have at least a changed value', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->successResponse($author);
    }

    /**
     *
     * @return  Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);
        $author->delete();

        return $this->successResponse($author);
    }

    //
}
