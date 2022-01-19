<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Author;
use App\Traits\ApiResponser;
use Respose;

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
     * return authors list.
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors);
    }

    /**
     * Create an instance of Author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
            'age' => 'required|integer'
        ];

        $this->validate($request, $rules);
        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Return an especific Author
     * @return Illuminate\Http\Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     * Update the information of an existing Author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
            'age' => 'integer'
        ];

        $this->validate($request, $rules);
        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->successResponse($author);
    }

    /**
     * Remove an existing Author
     * @return Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);
        $author -> delete();

        return $this->successResponse($author);
    }

    
}
