/*******w******** 
        
        Name: Shivkumar Lad
        Date: June 21, 2024
        Description: Search Forms With Keywords

    ****************/
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Pages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Search Pages</h1>
        <form action="search_results.php" method="get">
            <div class="form-group">
                <label for="keyword">Keyword</label>
                <input type="text" name="keyword" id="keyword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <a href="list_pages.php" class="btn btn-secondary mt-3">Back to Pages</a>
    </div>
</body>
</html>
