<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashLens Home</title>
    
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
<div class="container my-4">
        <div class="row g-4">

            <!-- Left Column -->
            <div class="col-lg-6">
                <!-- Budget Snippet -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Budget Overview</h5>
                        <div id="pie-chart" class="mb-3" style="height:200px; background:#f8f9fa; border-radius:8px;"></div>
                        <a href="budgets.php" class="btn btn-primary w-100">View / Edit Budgets</a>
                    </div>
                </div>

                <!-- Transactions -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Recent Transactions</h5>
                        <div id="transactions-list" class="mb-3" style="height:150px; background:#f8f9fa; border-radius:8px; overflow:auto;">
                            <!-- transactions will load here -->
                        </div>
                        <button id="add" class="btn btn-success w-100">Add Transaction</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-6">
                <!-- Upload -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Upload Bank Statement</h5>
                        <p class="text-muted">Supported format: .csv</p>
                        <input type="file" class="form-control mb-3" id="uploadFile" accept=".csv">
                        <button class="btn btn-primary w-100">Upload</button>
                    </div>
                </div>

                <!-- AI Summary -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">AI Insights</h5>
                        <div id="ai-summary" style="min-height:150px; background:#f8f9fa; border-radius:8px; padding:10px;">
                            <!-- AI suggestions will be displayed here -->
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-outline-primary flex-fill">Generate Summary</button>
                            <button class="btn btn-outline-secondary flex-fill">Refresh</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById("add").addEventListener("click", function () {
            alert("Here you’d open a Bootstrap modal with a form to add a transaction.");
        });
    </script>
</body>
</html>

