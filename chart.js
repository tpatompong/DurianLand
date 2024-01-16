document.addEventListener('DOMContentLoaded', function () {

  const doughnutConfig = {
    type: 'doughnut',
    data: datasets.data1, // Initial dataset
  };

  const doughnutCanvas = document.getElementById('myDoughnutChart');
  const doughnutCtx = doughnutCanvas.getContext('2d');

  let myDoughnutChart = new Chart(doughnutCtx, doughnutConfig);

  window.updateDoughnutChart = function () {
    const selector = document.getElementById('doughnutDataSelector');
    console.log('Selected dataset:', selector.value);
  
    const currentDataSet = selector.value;
  
    myDoughnutChart.destroy();
    myDoughnutChart = new Chart(doughnutCtx, {
      type: 'doughnut',
      data: datasets[currentDataSet],
    });
  };
  

  // Line Chart Configuration
  const lineConfig = {
    type: 'line',
    data: lineData.data3, 
  };
  
  const lineCanvas = document.getElementById('myLineChart');
  const lineCtx = lineCanvas.getContext('2d');
  
  let myLineChart = new Chart(lineCtx, lineConfig);
  
  window.updateLineChart = function () {
    const selector = document.getElementById('lineDataSelector');
    const currentDataSet2 = selector.value;
  
    myLineChart.destroy();
    myLineChart = new Chart(lineCtx, {
      type: 'line',
      data: lineData[currentDataSet2],
    });
  };
  
// Bar Chart Configuration
    const barConfig = {
      type: 'bar',
      data: barData.data5,
  };

  const barCanvas = document.getElementById('myBarChart');
  const barCtx = barCanvas.getContext('2d'); 

  let myBarChart = new Chart(barCtx, barConfig);

  window.updateBarChart = function () {
    const selector = document.getElementById('barDataSelector');
    const currentDataSet3 = selector.value;
  
    myBarChart.destroy();
    myBarChart = new Chart(barCtx, {
      type: 'bar',
      data: barData[currentDataSet3],
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  };   

});

