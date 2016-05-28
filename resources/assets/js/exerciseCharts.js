$(document).ready(function() {

  // for each exercise add a canvas to history.blade.php
  // reformat the date of the associated sets
  // and create a line chart showing the change 
  // in set weight over time
  for(var i = 0; i < exercises.length; i++) {

    $('#chart'+i).append('<canvas id="canvas'+i+'" height="2" width="2"></canvas></div>');

    // reformat dates
    var labels = Array.from(exercises[i].sets, x => x.created_at);
    for(var j = 0; j < labels.length; j++) {
      var date = new Date(labels[j]);
      labels[j] = date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear();
    }

    var ctx = document.getElementById("canvas"+i);
    var data = {
      labels: labels,
      datasets: [
        {
          label: exercises[i].name,
          fill: false,
          lineTension: 0.1,
          backgroundColor: "rgba(75,192,192,0.4)",
          borderColor: "rgba(75,192,192,1)",
          borderCapStyle: 'butt',
          borderDash: [],
          borderDashOffset: 0.0,
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(75,192,192,1)",
          pointBackgroundColor: "#fff",
          pointBorderWidth: 1,
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(75,192,192,1)",
          pointHoverBorderColor: "rgba(220,220,220,1)",
          pointHoverBorderWidth: 2,
          pointRadius: 1,
          pointHitRadius: 10,
          data: Array.from(exercises[i].sets, x => x.weight),
        }
      ]
    };

    var options = {
      scales: {
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Weight'
          }
        }]
      }
    };

    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: data,
      options: options
    });
  };
});