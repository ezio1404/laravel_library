@extends('layouts.layout')
@section('create')

<div class="w-2/3 bg-gray-200 mx-auto p-6 my-10 shadow flex flex-col items-center">
    <form action="/authors" method="post" class="flex flex-col items-center">
        @csrf
        <h1>Add new Author</h1>
        <div class="pt-4">
            <input type="text" name="name" id="name" class="rounded px-4 py-2 w-64" placeholder="Full name">
        <p class="text-red-600">@error('name'){{$message}}@enderror</p>
        </div>
        <div class="pt-4">
            <input type="text" name="dob" id="dob" class="rounded px-4 py-2 w-64" placeholder="Date of Birth">
        </div>
        <div class="pt-4">
            <button class="bg-blue-400 text-white rounded py-2 px-4">Add new Author</button>
        </div>
    </form>

</div>
@show
