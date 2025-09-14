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

            
            <div class="col-lg-6">
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Budget Overview</h5>
                        <div id="pie-chart" class="mb-3" style="height:200px; background:#f8f9fa; border-radius:8px;"></div>
                        <a href="budgets.php" class="btn btn-outline-primary w-100">View / Edit Budgets</a>
                    </div>
                </div>

                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Recent Transactions</h5>
                        <div id="transactions-list" class="mb-3" style="height:150px; background:#f8f9fa; border-radius:8px; overflow:auto;">
                            
                        </div>
                        <button id="add" class="btn btn-outline-success w-100"><img src="/assets/imgs/add-transac.png" alt="Points" class="me-1" style="height:20px;">  Add Transaction</button>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Upload Bank Statement</h5>
                        <p class="text-muted">Supported format: .csv</p>
                        <input type="file" class="form-control mb-3" id="uploadFile" accept=".csv">
                        <button id="uploadBtn" class="btn btn-secondary w-100">Upload</button>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">AI Insights</h5>
                        <div id="ai-summary" style="min-height:270px; background:#f8f9fa; border-radius:8px; padding:10px;">
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-outline-secondary flex-fill">Refresh</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="transactionModalLabel">Add Transaction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="transaction-form">
          <div class="mb-3">
            <label for="transaction-type" class="form-label">Type</label>
            <select id="transaction-type" class="form-select">
              <option value="income">Income</option>
              <option value="expense">Expense</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="transaction-category" class="form-label">Category</label>
            <select id="transaction-category" class="form-select">
              <option value="food">Food</option>
              <option value="transport">Transport</option>
              <option value="shopping">Shopping</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="transaction-amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="transaction-amount" required>
          </div>

          <div class="mb-3">
            <label for="transaction-description" class="form-label">Description</label>
            <input type="text" class="form-control" id="transaction-description">
          </div>

          <div class="mb-3">
            <label for="transaction-date" class="form-label">Date</label>
            <input type="date" class="form-control" id="transaction-date" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
      </div>

    </div>
  </div>
</div>


    <script src="../../assets/js/index.js"></script>
</body>
</html>

