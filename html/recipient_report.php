<?php
include_once 'ltr/header.php'; // Including header
include_once 'connection.php';  // Database connection

// Fetch client names from client_master table
$sql = "SELECT client_name FROM client_master";
$result = $con->query($sql);

// Prepare an array to store client names
$clients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row['client_name'];
    }
} else {
    $clients = [];
}

$portfolio_services = ['pan', 'tan', 'e_tds', 'other_services', 'it_returned', 'e_tender', 'gst_fees', 'dsc_subscriber', 'dsc_token', 'dsc_reseller'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt Report</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Global styles */
    body {
        display: flex;
        margin: 0;
        font-family: Arial, sans-serif;
        height: 100vh;
        overflow: hidden; /* Prevent scrolling the entire page */

    }

    .sidebar {
        width: 400px;
        background-color: #f4f4f4;
        border-right: 1px solid #ccc;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        height: 100vh; 
    }

    .sidebar-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .sidebar-section h5 {
        font-size: 16px;
        cursor: pointer;
        color: #333;
        margin-bottom: 10px;
    }

    .sidebar-section h5 i {
        margin-right: 8px;
    }

    .sidebar-content {
        margin-bottom: 20px;
        padding-left: 10px;
    }

    .sidebar-content .form-group {
        margin-bottom: 15px;
    }

    .custom-btn {
        background-color: #007bff; /* Blue color */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-btn:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: scale(1.05); /* Slight zoom effect */
    }

    .main-content {
        flex: 1;
        padding: 20px;
        overflow-y: auto; /* Enable scrolling for the main content */
        height: 100vh;
    }

    .report-container {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dropdown-container {
        position: relative;
        margin-bottom: 20px;
    }

    .dropdown {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
        padding: 10px;
    }

    .dropdown label {
        display: block;
        margin-bottom: 5px;
    }

    .dropdown-container .form-control {
        cursor: pointer;
    }

    /* Export Button */
    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <!-- Sidebar with Filters -->
      <div class="col-md-3 sidebar">
        <h4 class="sidebar-title">Filters</h4>
        
        <!-- Date Range Filter -->
        <div class="sidebar-section">
          <h5 onclick="toggleSection('dateSection')"><i class="fas fa-calendar-alt"></i> Date Range</h5>
          <div id="dateSection" class="sidebar-content">
            <div class="form-group">
              <label for="fromDate">From Date:</label>
              <input type="date" id="fromDate" class="form-control" value="2025-01-01">
            </div>
            <div class="form-group">
              <label for="toDate">To Date:</label>
              <input type="date" id="toDate" class="form-control" value="2025-12-31">
            </div>
          </div>
        </div>

        <!-- Recipient Dropdown -->
        <div class="dropdown-container">
          <label for="recipientSelected">
            <i class="fa fa-users"></i> Recipient
          </label>
          <input type="text" id="recipientSelected" readonly value="All" class="form-control" onclick="toggleDropdown('recipientDropdown')">
          <div class="dropdown" id="recipientDropdown" style="display: none;">
            <label>
              <input type="checkbox" class="recipient-checkbox" value="All" onclick="handleCheckboxClick('recipient', this)"> All
            </label>
            <?php 
            if (empty($clients)) {
                echo "<p>No clients available</p>";
            } else {
                foreach ($clients as $client) {
                    echo '<label>
                            <input type="checkbox" class="recipient-checkbox" value="' . htmlspecialchars($client) . '" onclick="handleCheckboxClick(\'recipient\', this)"> ' . htmlspecialchars($client) . '
                          </label>';
                }
            }
            ?>
          </div>
        </div>

        <!-- Portfolio Dropdown -->
        <div class="dropdown-container">
          <label for="portfolioSelected">
            <i class="fa fa-briefcase"></i> Portfolio
          </label>
          <input type="text" id="portfolioSelected" readonly value="All" class="form-control" onclick="toggleDropdown('portfolioDropdown')">
          <div class="dropdown" id="portfolioDropdown" style="display: none;">
            <label>
              <input type="checkbox" class="portfolio-checkbox" value="All" onclick="handleCheckboxClick('portfolio', this)"> All
            </label>
            <?php foreach ($portfolio_services as $service): ?>
                <label>
                  <input type="checkbox" class="portfolio-checkbox" value="<?php echo $service; ?>" onclick="handleCheckboxClick('portfolio', this)"> <?php echo ucfirst($service); ?>
                </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Generate Report Button -->
        <button type="button" class="btn custom-btn mt-3 w-100" onclick="generateReport()">Generate Report</button>
        </div>

      <!-- Main Content Area -->
      <div class="col-md-9 main-content">
        <div class="header">
          <h2 class="text-center mb-4">📊 Recipient Report</h2>
        </div>

        <div class="report-container">
          <h3 class="report-title">Generated Report</h3><br>
          <div class="export-options">
            <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
          </div><br>
          <div class="table-responsive">
            <div id="reportContent" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script>
    // Toggle dropdown visibility
    function toggleDropdown(dropdownId) {
      const dropdown = document.getElementById(dropdownId);
      dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    // Handle checkbox selection and update the field
    function handleCheckboxClick(type, checkbox) {
      const selectedValues = getSelectedValues(type);
      document.getElementById(type + 'Selected').value = selectedValues.join(', ') || 'All';
      fetchReportData();
    }

    // Get selected values from checkboxes
    function getSelectedValues(type) {
      const checkboxes = document.querySelectorAll(`.${type}-checkbox:checked`);
      return Array.from(checkboxes).map(cb => cb.value);
    }

    // Function to fetch report data based on selected filters
    function fetchReportData() {
      const recipients = getSelectedValues('recipient');
      const portfolios = getSelectedValues('portfolio');

      let reportData = `
        <table class="table">
          <thead>
            <tr>
              <th>Client Name</th>
              <th>Service</th>
              <th>Fees</th>
              <th>Fees Receipt</th>
            </tr>
          </thead>
          <tbody>
      `;

      // Example data for each selected portfolio
      portfolios.forEach(portfolio => {
        recipients.forEach(recipient => {
          reportData += `
            <tr>
              <td>${recipient}</td>
              <td>${portfolio}</td>
              <td>Example Fee</td>
              <td>Example Receipt</td>
            </tr>
          `;
        });
      });

      reportData += '</tbody></table>';
      document.getElementById('reportContent').innerHTML = reportData;
    }

    // Export data to Excel
    function exportToExcel() {
      const table = document.getElementById('reportContent').querySelector('table');
      if (table) {
        const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(wb, "report.xlsx");
      }
    }
  </script>
</body>
</html>

<?php
include_once 'ltr/header-footer.php'; // Including footer
?>
