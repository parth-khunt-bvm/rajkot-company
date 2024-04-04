@extends('backend.employee.layout.app')
@section('section')

@csrf
@endsection



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recorder Button</title>
<style>
  #recorderButton {
    width: 80px;
    height: 80px;
    background-color: red;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    color: white;
    cursor: pointer;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    position: relative;
    border: none; /* Remove border */
  }
  #squareInside {
    width: 40px;
    height: 40px;
    background-color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 10px; /* Add border-radius to the square */
  }
</style>
</head>
<body>

<button id="recorderButton">
  <div id="squareInside"></div>
</button>

</body>
</html>




