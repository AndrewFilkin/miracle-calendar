<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocomplete Search</title>
    <style>
        #results {
            list-style-type: none;
            padding: 0;
        }

        #results li {
            border: 1px solid #ccc;
            padding: 8px;
            margin: 2px 0;
        }
    </style>
</head>
<body>
<input type="text" id="search-box" placeholder="Search...">
<ul id="results"></ul>

<script>
    document.getElementById('search-box').addEventListener('input', function () {
        const query = this.value;

        if (query.length > 2) {
            fetch(`http://localhost:8000/api/admin/search/not-approved/user?query=${query}`, {
                headers: {
                    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzE4MTg0NTgzLCJleHAiOjE3MTg3ODkzODMsIm5iZiI6MTcxODE4NDU4MywianRpIjoiTGI0cVhaRHJOMlNBYTFFRSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.GjM9RGvuibuw0kE5Tk1VHhcHe72Bvaf-SwxthTAXhNQ',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    let resultsContainer = document.getElementById('results');
                    resultsContainer.innerHTML = '';
                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.textContent = item.name;
                        resultsContainer.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching autocomplete data:', error));
        }
    });
</script>
</body>
</html>
