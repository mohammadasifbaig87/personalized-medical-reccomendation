<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Personalized Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .dashboard-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Medicine Recommendation</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Symptom Input Section -->
            <div class="col-md-6 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Enter Your Symptoms</h5>
                        <form id="symptomForm">
                            <textarea class="form-control" id="symptomInput" rows="4" placeholder="Enter your symptoms here"></textarea>
                            <button type="button" class="btn btn-primary mt-3" onclick="submitSymptoms()">Submit Symptoms</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Medicine Recommendations Section -->
            <div class="col-md-6 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recommendations</h5>
                        <p id="medicineRecommendation">Medicine will be shown here after submitting symptoms.</p>
                        <p id="precautionsRecommendation">Precautions will be shown here.</p>
                        <p id="dietRecommendation">Diet recommendations will be shown here.</p>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div class="col-md-12 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">History</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Symptoms</th>
                                    <th>Medicine</th>
                                    <th>Precautions</th>
                                    <th>Diet</th>
                                </tr>
                            </thead>
                            <tbody id="historyTable">
                                <!-- History records will be shown here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function submitSymptoms() {
            var symptoms = document.getElementById("symptomInput").value;

            if (symptoms === "") {
                alert("Please enter symptoms.");
                return;
            }

            // Sending symptoms to the backend using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_symptoms.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Displaying recommendations
                    document.getElementById("medicineRecommendation").innerText = "Medicine: " + response.medicine;
                    document.getElementById("precautionsRecommendation").innerText = "Precautions: " + response.precautions;
                    document.getElementById("dietRecommendation").innerText = "Diet: " + response.diet;

                    // Saving the history record (optional)
                    addHistoryRow(symptoms, response.medicine, response.precautions, response.diet);
                }
            };

            xhr.send(JSON.stringify({ symptom: symptoms }));
        }

        function addHistoryRow(symptom, medicine, precautions, diet) {
            var table = document.getElementById("historyTable");
            var row = table.insertRow(0); // Add at the top of the table
            row.insertCell(0).innerText = symptom;
            row.insertCell(1).innerText = medicine;
            row.insertCell(2).innerText = precautions;
            row.insertCell(3).innerText = diet;
        }
    </script>
</body>
</html>
