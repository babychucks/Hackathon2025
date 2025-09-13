document.addEventListener("DOMContentLoaded", function () {
    loadTransactions();

    const addBtn = document.getElementById("add");
    const transactionModal = new bootstrap.Modal(document.getElementById("transactionModal"));

    addBtn.addEventListener("click", function () {
        transactionModal.show();
    });


    const transactionForm = document.getElementById("transaction-form");

    transactionForm.addEventListener("submit", function (e) {
        e.preventDefault();


        const type = document.getElementById("transaction-type").value;
        const category = document.getElementById("transaction-category").value;
        const amount = document.getElementById("transaction-amount").value;
        const description = document.getElementById("transaction-description").value;
        const date = document.getElementById("transaction-date").value;
        const apiKey = localStorage.getItem("api_key") || "";
        console.log("Api_key = " + apiKey)


        var transactionData = {
            type: "AddTransaction",
            "api_key": apiKey,
            "transaction_type": type,
            "category": category,
            "amount": amount,
            "date": date,
            "description": description
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/src/backend/api.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");


        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log("Response:", response);
            }
        };

        req.send(JSON.stringify(transactionData));


        transactionModal.hide();

        transactionForm.reset();

    });


});

function loadTransactions() {
    const apiKey = localStorage.getItem("api_key") || "";
    console.log("Api_key = " + apiKey)

    var requestData = {
        type: "GetTransactions",
        api_key: apiKey
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/src/backend/api.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success && Array.isArray(response.transactions)) {
                        displayTransactions(response.transactions);
                    } else {
                        console.error("Invalid response:", response);
                        document.getElementById("transactions-list").innerHTML =
                            `<p class="text-muted">No transactions found.</p>`;
                    }
                } catch (err) {
                    console.error("Error parsing JSON:", err);
                }
            } else {
                console.error("Error fetching transactions:", xhr.statusText);
            }
        }
    };

    xhr.send(JSON.stringify(requestData));
}

function displayTransactions(transactions) {
    const container = document.getElementById("transactions-list");
    container.innerHTML = "";
    if (transactions.length === 0) {
        container.innerHTML = `<p class="text-muted">No transactions yet.</p>`;
        return;
    }

    for (var i = 0; i < transactions.length; i++) {
        var transac = transactions[i];
        var transacDiv = document.createElement("div");
        transacDiv.className = "p-2 border-bottom";

        var badgeClass = (transac.amount >= 0) ? "success" : "danger";
        var description = transac.description ? transac.description : "No description";

        transacDiv.innerHTML =
            '<div class="d-flex justify-content-between">' +
            '<div>' +
            '<strong>' + transac.category + '</strong> ' +
            '<span class="text-muted">(' + description + ')</span>' +
            '</div>' +
            '<div>' +
            '<span class="badge bg-' + badgeClass + '">' +
            transac.amount +
            '</span>' +
            '</div>' +
            '</div>' +
            '<small class="text-muted">' + transac.date + '</small>';

        container.appendChild(transacDiv);
    }
}

