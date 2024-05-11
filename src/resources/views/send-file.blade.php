<html>
<head>
    <title>
        lalala
    </title>
</head>
<body>
<form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="files[]" multiple>
    <button type="submit">Upload File</button>
</form>

</body>
</html>
