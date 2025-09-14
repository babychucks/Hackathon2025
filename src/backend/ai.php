<?php
header("Content-Type: application/json");

$apiKey =getenv("GEMINI_API_KEY");
//    echo json_encode(["output" => $apiKey]);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
   
    $fileTmp = $_FILES['csv']['tmp_name'];
    $csvContent = file_get_contents($fileTmp);
    
    $fullPrompt = "You are a financial advisor AI. Analyze the following CSV transaction data and generate a monthly budget. 
The transactions are in the format: Date, Description, Amount. Negative amounts are expenses.

Instructions:
1. Categorize each expense into one of these categories only:
   - Net Income
   - Food and Groceries
   - Entertainment and Lifestyle
   - Transport
   - Savings and Investment
   - Housing
   - Utilities and Subscriptions
   - Other
2. Sum the total spending for each category (only negative amounts). For Net Income add all positives please.
3. Based on the spending, suggest a reasonable monthly budget allocation for each  category (if the category applies/exist. Skip the category if it doesnt apply).
4. Round all allocated amounts to the nearest whole number.
5. Return ONLY a list of categories and their allocated amounts. 
   Example format (no explanations, no extra text):
   Food and Groceries: 1200
   Transport: 800
   Entertainment and Lifestyle: 500
   Housing: 4000
   Utilities and Subscriptions: 1500
   Savings and Investment: 1000"
     . "\n\nHere is the CSV data:\n" . $csvContent;

    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=".$apiKey;

    $data = [
        "contents" => [
            ["parts" => [["text" => $fullPrompt]]]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    
    $result = json_decode($response, true);
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        $output = $result['candidates'][0]['content']['parts'][0]['text'];
    } elseif (isset($result['error']['message'])) {
        $output = "Error: " . $result['error']['message'];
    } else {
        $output = "Unexpected response: " . json_encode($result);
    }
    echo json_encode(["output" => $output]);
} else {
    echo json_encode(["error" => "No CSV uploaded."]);
}

