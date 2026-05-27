
@extends('layouts.app')

@section('title', 'About')

@section('content')

    <div class="home-box">
        <h1>ℹ️ About This System</h1>
        <p style="margin-top:15px; font-size:16px; color:#555;">
            This Student Dashboard was built using <strong>Laravel Blade Templating</strong>.
        </p>
        <ul style="margin-top:15px; font-size:15px; color:#555; padding-left:20px; line-height:2;">
            <li>Uses <strong>@@extends</strong> and <strong>@@section</strong> for layout inheritance</li>
            <li>Uses <strong>@@forelse / @@empty</strong> for loop and empty data handling</li>
            <li>Uses <strong>@@if / @@elseif / @@else</strong> for conditional student status</li>
        </ul>
    </div>

@endsection