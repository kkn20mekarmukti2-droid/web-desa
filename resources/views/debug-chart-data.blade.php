<!DOCTYPE html>
<html>
<head>
    <title>Chart Data Debug</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>🔍 Debug Chart Data Response</h2>
    <div id="results"></div>
    
    <script>
    // Test different data endpoints
    const testUrls = [
        '{{ route("getdatades", ["type" => "penduduk"]) }}',
        '{{ route("getdatades", ["type" => "agama"]) }}',
        '{{ route("getdatades", ["type" => "profesi"]) }}'
    ];
    
    testUrls.forEach((url, index) => {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                console.log(`Data ${index + 1}:`, data);
                
                // Test percentage calculation
                const total = data.data.reduce((a, b) => Number(a) + Number(b), 0);
                const percentages = data.data.map(val => {
                    const percentage = ((Number(val) / total) * 100).toFixed(1);
                    return percentage;
                });
                
                document.getElementById('results').innerHTML += `
                    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                        <h3>URL ${index + 1}: ${url}</h3>
                        <p><strong>Labels:</strong> ${JSON.stringify(data.labels)}</p>
                        <p><strong>Data:</strong> ${JSON.stringify(data.data)}</p>
                        <p><strong>Data Types:</strong> ${data.data.map(v => typeof v).join(', ')}</p>
                        <p><strong>Total:</strong> ${total}</p>
                        <p><strong>Percentages:</strong> ${JSON.stringify(percentages)}</p>
                    </div>
                `;
            })
            .catch(error => {
                console.error(`Error ${index + 1}:`, error);
            });
    });
    </script>
</body>
</html>
