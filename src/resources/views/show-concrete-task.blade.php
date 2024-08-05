<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('76b0b04ec4259ed99f3d', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('comment-channel-402');
        channel.bind('comment-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>

</head>
<body>
<h1>Task Details</h1>
<div id="task-details"></div>
<h2>Comments</h2>
<div id="comments"></div>

<script>
    fetch('http://localhost:8000/api/task/show-concrete-task/402', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzIyNjgzMDM0LCJleHAiOjE3MjMyODc4MzQsIm5iZiI6MTcyMjY4MzAzNCwianRpIjoieURiOWQxNHlYZTVXT2RHbCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.30N0Sgvp9AchT7YItUQzVGvXXdKoDm5bEPlDMlYT8vU',
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            const task = data.task;
            const comments = data.comments;

            // Display task details
            const taskDetailsDiv = document.getElementById('task-details');
            taskDetailsDiv.innerHTML = `
                <p>ID: ${task.id}</p>
                <p>Name: ${task.name}</p>
                <p>Description: ${task.description}</p>
                <p>Start Date: ${task.start_date}</p>
                <p>End Date: ${task.end_date}</p>
                <p>Is Completed: ${task.is_completed}</p>
                <p>Is Urgently: ${task.is_urgently}</p>
                <p>Creator ID: ${task.creator_id}</p>
                <p>Created At: ${task.created_at}</p>
                <p>Updated At: ${task.updated_at}</p>
            `;

            // Display comments
            const commentsDiv = document.getElementById('comments');
            comments.forEach(comment => {
                commentsDiv.innerHTML += `
                    <div>
                        <p>Comment ID: ${comment.id}</p>
                        <p>User ID: ${comment.user_id}</p>
                        <p>Comment: ${comment.comment}</p>
                        <p>Created At: ${comment.created_at}</p>
                        <p>Updated At: ${comment.updated_at}</p>
                        <p>File: <a href="${comment.file}" target="_blank">Download</a></p>
                    </div>
                    <hr>
                `;
            });
        })
        .catch(error => console.error('Error fetching task data:', error));
</script>
</body>
</html>
