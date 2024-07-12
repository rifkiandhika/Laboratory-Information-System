
var xtc = document.getElementById("myAreaChart");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [227, 219, 219, 215, 232, 225, 230, 216, 221, 229, 228, 218, 232, 224, 227, 226, 219, 217, 223, 232, 216, 228, 220, 232, 215, 218, 231, 230, 219, 223, 221],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Lym# graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-1");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [221, 227, 231, 218, 229, 225, 231, 219, 227, 220, 231, 223, 216, 226, 229, 219, 228, 232, 220, 217, 216, 223, 219, 224, 232, 232, 231, 220, 229, 225, 224],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Mid% graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-2");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [222, 219, 221, 225, 228, 229, 229, 219, 221, 225, 224, 224, 219, 219, 227, 221, 229, 228, 226, 221, 220, 221, 224, 217, 220, 227, 229, 220, 219, 226, 226],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Gran graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-3");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [227, 224, 219, 218, 218, 224, 218, 218, 218, 219, 220, 217, 218, 216, 232, 219, 230, 218, 219, 227, 228, 217, 217, 218, 231, 216, 227, 220, 219, 232, 228],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Lym# graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-4");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [221, 227, 231, 218, 229, 225, 231, 219, 227, 220, 231, 223, 216, 226, 229, 219, 228, 232, 220, 217, 216, 223, 219, 224, 232, 232, 231, 220, 229, 225, 224],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Mid% graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-5");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [222, 219, 221, 225, 228, 229, 229, 219, 221, 225, 224, 224, 219, 219, 227, 221, 229, 228, 226, 221, 220, 221, 224, 217, 220, 227, 229, 220, 219, 226, 226],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// Gran graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-6");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [227, 224, 219, 218, 218, 224, 218, 218, 218, 219, 220, 217, 218, 216, 232, 219, 230, 218, 219, 227, 228, 217, 217, 218, 231, 216, 227, 220, 219, 232, 228],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// WBC graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-7");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [226, 221, 219, 219, 223, 226, 219, 217, 232, 227, 216, 220, 215, 229, 220, 217, 219, 216, 231, 231, 223, 219, 217, 217, 223, 216, 231, 231, 217, 229, 220],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// HGB graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-8");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [222, 219, 221, 230, 218, 220, 226, 232, 219, 230, 227, 226, 228, 218, 217, 232, 224, 217, 228, 230, 231, 223, 217, 224, 219, 219, 229, 230, 216, 218, 231],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// HCT graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-9");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [225, 216, 219, 232, 231, 219, 222, 227, 231, 217, 225, 225, 222, 216, 231, 219, 217, 221, 220, 225, 231, 226, 218, 216, 227, 225, 216, 226, 231, 229, 231],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// MCV graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-10");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [219, 228, 220, 231, 222, 232, 225, 217, 231, 217, 216, 232, 216, 226, 218, 218, 223, 231, 217, 229, 231, 218, 232, 217, 218, 229, 217, 215, 221, 216, 218        ],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// MCH graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-11");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [218, 216, 223, 225, 219, 231, 230, 219, 218, 217, 217, 232, 226, 219, 223, 217, 219, 227, 231, 228, 219, 230, 220, 226, 220, 216, 228, 217, 218, 229, 224],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// MCHC graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-12");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [219, 217, 232, 231, 218, 221, 220, 216, 225, 231, 228, 232, 216, 219, 217, 218, 222, 215, 217, 230, 225, 228, 231, 223, 220, 216, 221, 216, 218, 217, 219],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// RDW-CV graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-13");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [219, 218, 219, 217, 218, 232, 225, 217, 221, 218, 225, 230, 220, 232, 216, 228, 216, 220, 227, 229, 231, 230, 222, 229, 219, 217, 232, 216, 217, 218, 223],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// RDW-SD graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-14");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [220, 216, 217, 227, 228, 230, 221, 225, 218, 228, 220, 223, 216, 219, 217, 222, 215, 219, 222, 231, 217, 219, 223, 225, 216, 229, 230, 221, 225, 219, 217],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// PLT graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-15");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [223, 220, 231, 228, 217, 231, 216, 219, 230, 218, 217, 220, 226, 228, 218, 217, 230, 226, 218, 220, 217, 215, 231, 218, 219, 219, 225, 225, 219, 219, 232],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// MPV graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-16");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [220, 218, 231, 217, 222, 219, 230, 216, 217, 225, 220, 216, 217, 217, 222, 219, 217, 218, 230, 219, 219, 216, 228, 219, 225, 218, 225, 216, 220, 232, 221],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// PDW graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-17");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [230, 221, 226, 222, 217, 218, 218, 219, 222, 219, 218, 216, 220, 220, 231, 217, 220, 228, 232, 218, 217, 231, 217, 228, 221, 225, 216, 218, 221, 216, 229],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// PCT graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-18");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [221, 218, 217, 219, 229, 228, 216, 220, 218, 221, 220, 221, 217, 218, 222, 229, 219, 221, 227, 218, 225, 217, 220, 222, 231, 217, 228, 219, 217, 223, 216],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// P-LCR graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-19");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [222, 219, 218, 229, 220, 220, 231, 229, 217, 220, 219, 218, 219, 229, 217, 217, 216, 223, 220, 217, 220, 219, 228, 231, 216, 230, 229, 228, 223, 225, 220],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
// P-LCC graph
// Area Chart Example
var xtc = document.getElementById("myAreaChart-20");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [219, 218, 220, 231, 222, 217, 217, 220, 219, 227, 219, 225, 218, 230, 230, 219, 222, 217, 216, 220, 216, 220, 223, 218, 216, 217, 231, 217, 217, 219, 218],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});


