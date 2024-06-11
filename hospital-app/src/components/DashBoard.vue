<template>
  <div class="content">
    <section class="dashboard-stats">
      <div class="stat">
        <h2>Users</h2>
        <p>123</p>
      </div>
      <div class="stat">
        <h2>Doctors</h2>
        <p>50</p>
      </div>
      <div class="stat">
        <h2>Patients</h2>
        <p>500</p>
      </div>
    </section>
    <section class="dashboard-charts">
      <h2>Recent Activity</h2>
      <div class="chart">
        <!-- chart component here -->
      </div>
    </section>
    <section class="dashboard-tables">
      <h2>Recent Appointments</h2>
      <table>
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Doe</td>
            <td>Dr. Smith</td>
            <td>2022-01-01</td>
            <td>10:00 AM</td>
          </tr>
          <!-- more table rows here -->
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
};
</script>

<style scoped>
.content {
  margin-left: 240px; /* width of the sidebar */
  padding: 80px 20px 20px; /* add padding top equal to the height of the header */
}

.dashboard-stats {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 20px;
}

.stat {
  margin: 20px;
  width: 200px;
  background-color: #fff;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.stat h2 {
  margin-top: 0;
}

.dashboard-charts {
  padding: 20px;
}

.chart {
  width: 100%;
  height: 300px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.dashboard-tables {
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f0f0f0;
}
</style>