<?php
include('../admin/includs/header.php');
$conn = mysqli_connect('localhost', 'root', '', 'machtala') or die('connection failed');
// Récupération des chiffres
$plantes       = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM plantes"));
$pepinieres    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pepiniere"));
$users         = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$messages      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM message"));
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Bienvenue dans votre espace d'administration</li>
    </ol>
    <div class="row">
        <!-- Plantes -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Plantes ajoutées</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h3><?= $plantes ?></h3>
                </div>
            </div>
        </div>
        <!-- Pépinières -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Pépinières ajoutées</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h3><?= $pepinieres ?></h3>
                </div>
            </div>
        </div>
        <!-- Utilisateurs -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Utilisateurs inscrits</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h3><?= $users ?></h3>
                </div>
            </div>
        </div>
        <!-- Messages -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Messages reçus</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h3><?= $messages ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Section du graphique -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Statistiques des éléments
                </div>
                <div class="card-body">
                    <canvas id="dashboardChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('dashboardChart').getContext('2d');
  const dashboardChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Plantes', 'Pépinières', 'Utilisateurs', 'Messages'],
          datasets: [{
              label: 'Nombre',
              data: [
                <?= $plantes ?>,
                <?= $pepinieres ?>,
                <?= $users ?>,
                <?= $messages ?>
              ],
              backgroundColor: [
                  'rgba(40, 167, 69, 0.5)',
                  'rgba(0, 123, 255, 0.5)',
                  'rgba(255, 193, 7, 0.5)',
                  'rgba(220, 53, 69, 0.5)'
              ],
              borderColor: [
                  'rgba(40, 167, 69, 1)',
                  'rgba(0, 123, 255, 1)',
                  'rgba(255, 193, 7, 1)',
                  'rgba(220, 53, 69, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      precision: 0
                  }
              }
          },
          responsive: true,
          plugins: {
              legend: {
                  display: false
              }
          }
      }
  });
</script>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
