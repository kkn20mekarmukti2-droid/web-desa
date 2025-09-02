<!DOCTYPE html>
<html>
<head>
    <title>Test User API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Test User API</h2>
    <button onclick="testShowUser()">Test Show User API</button>
    <div id="result"></div>

    <script>
        function testShowUser() {
            fetch('/admin/users/1', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p style="color: red;">Error: ' + error + '</p>';
            });
        }
    </script>
</body>
</html>
