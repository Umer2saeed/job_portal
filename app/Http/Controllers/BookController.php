<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'DESC');
        if (!empty($request->keyword))
        {
            $books = $books->where('title', 'like', '%'.$request->keyword.'%')
                ->orWhere('author', 'like', '%'.$request->keyword.'%');

        }

        $books = $books->paginate(10);
        return view('books.list', [
            'books' => $books
        ]);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required'
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        // upload book image here
        if(!empty($request->image))
        {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
            $book->save();

            // create new image instance
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit',[
            'book' => $book
        ]);
    }

    public function update($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required'
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.edit', $book->id)->withInput()->withErrors($validator);
        }

        // update book in db
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        // upload book image here
        if(!empty($request->image))
        {
            // this will delete the old book image from the books directory
            File::delete(public_path('uploads/books/'.$book->image));
            File::delete(public_path('uploads/books/thumb/'.$book->image));
            $image = $request->image;

            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
            $book->save();

            // generate image thumbnail here
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy()
    {

    }

}
