<?php
$githubToken = '';
$baseApiUrl = 'https://api.github.com';

function githubApiRequest($url, $token) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "User-Agent: PHP-App"
    ]);

    $response = curl_exec($ch); 
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false) {
        die("cURL error: $error");
    }

    if ($httpCode !== 200) {
        die("HTTP error code: $httpCode. Response: $response");
    }

    $decodedResponse = json_decode($response, true);

    if (isset($decodedResponse['content'])) {
        $decodedResponse['content'] = base64_decode($decodedResponse['content']);
    }

    return $decodedResponse;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $username = $_GET['username'] ?? '';
    $repo = $_GET['repo'] ?? '';
    $filePath = $_GET['file'] ?? '';

    switch ($action) {
        case 'get_repos':
            if ($username) {
                $url = "$baseApiUrl/users/$username/repos";
                $repos = githubApiRequest($url, $githubToken);
                echo json_encode($repos);
            }
            break;

        case 'get_files':
            if ($username && $repo) {
                $url = "$baseApiUrl/repos/$username/$repo/contents";
                $files = githubApiRequest($url, $githubToken);
                echo json_encode($files);
            }
            break;

        case 'get_file_content':
            if ($username && $repo && $filePath) {
                $url = "$baseApiUrl/repos/$username/$repo/contents/$filePath";
                $file = githubApiRequest($url, $githubToken);
                echo json_encode($file);
            }
            break;
    }
}


function dump($variable){
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
    echo "</br>";
}
