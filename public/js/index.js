$(document).ready(function() {
	$('#workout_list').select2({
		placeholder: "Select Workouts"
	});

	$('#exercise_list').select2({
		placeholder: "Select Exercises"
	});

	var timerFunction = function (selector, timeMultiplier) {
    $(selector).addClass('hidden');
    $(selector).after('<a class="btn btn-success btn-block" id="timeOutput"></a>');

    $('#timeOutput').on('click', function () {
      clearInterval(interval);
      $(selector).removeClass('hidden');
      $('#timeOutput').remove();
    });
    
    var start = new Date().getTime();
    
    var interval = setInterval( function() {
      var now = 1000*60*timeMultiplier - (new Date().getTime() - start);
      if( now > 0 ) 
      {
      	var minutes = Math.floor(now / 1000 / 60);
      	var seconds = Math.floor(now / 1000 % 60);

      	var output = minutes + ':' + seconds;
      	if(minutes == 0) { output = seconds; }

        document.getElementById('timeOutput').innerHTML = output;
      }
      else
      {
        clearInterval(interval);
        $(selector).removeClass('hidden');
        $('#timeOutput').remove();
      }
    }, 100); 
  };

  $('.thirtySec').on('click', function () {timerFunction($(this), .5)});
  $('.oneMin').on('click', function () {timerFunction($(this), 1)});
  $('.twoMin').on('click', function () {timerFunction($(this), 2)});
  // $('.threeMin').on('click', function () {timerFunction($(this), 3)});
  // $('.fourMin').on('click', function () {timerFunction($(this), 4)});
  // $('.fiveMin').on('click', function () {timerFunction($(this), 5)});
});
