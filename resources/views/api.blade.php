@extends('app')

@section('content')

<h2>REST API</h2>

RESTful URLs and actions

<table class="table">
<tr><th>Method   </th><th>  URI </th>   
<tr><td>POST     </td><td>  /api/auth/login                                        </td></tr> 
<tr><td>POST     </td><td>  /api/auth/signup                                       </td></tr> 
<tr><td>POST     </td><td>  /api/auth/recovery                                     </td></tr> 
<tr><td>POST     </td><td>  /api/auth/reset                                        </td></tr> 
<tr><td>GET      </td><td>  /api/exercises/{exercise_id}/workouts/{id}/attach      </td></tr> 
<tr><td>GET      </td><td>  /api/exercises/{exercise_id}/workouts/{id}/detach      </td></tr> 
<tr><td>GET      </td><td>  /api/workouts/{workout_id}/exercises/{id}/attach       </td></tr> 
<tr><td>GET      </td><td>  /api/workouts/{workout_id}/exercises/{id}/detach       </td></tr> 
<tr><td>GET      </td><td>  /api/workouts/{workout_id}/groups/{id}/attach          </td></tr> 
<tr><td>GET      </td><td>  /api/workouts/{workout_id}/groups/{id}/detach          </td></tr> 
<tr><td>GET      </td><td>  /api/groups/{group_id}/workouts/{id}/attach            </td></tr> 
<tr><td>GET      </td><td>  /api/groups/{group_id}/workouts/{id}/detach            </td></tr> 
<tr><td>GET      </td><td>  /api/sets                                              </td></tr> 
<tr><td>POST     </td><td>  /api/sets                                              </td></tr> 
<tr><td>GET      </td><td>  /api/sets/{sets}                                       </td></tr> 
<tr><td>PUT|PATCH</td><td>  /api/sets/{sets}                                       </td></tr> 
<tr><td>DELETE   </td><td>  /api/sets/{sets}                                       </td></tr> 
<tr><td>GET      </td><td>  /api/exercises                                         </td></tr> 
<tr><td>POST     </td><td>  /api/exercises                                         </td></tr> 
<tr><td>GET      </td><td>  /api/exercises/{exercises}                             </td></tr> 
<tr><td>PUT|PATCH</td><td>  /api/exercises/{exercises}                             </td></tr> 
<tr><td>DELETE   </td><td>  /api/exercises/{exercises}                             </td></tr> 
<tr><td>GET      </td><td>  /api/workouts                                          </td></tr> 
<tr><td>POST     </td><td>  /api/workouts                                          </td></tr> 
<tr><td>GET      </td><td>  /api/workouts/{workouts}                               </td></tr> 
<tr><td>PUT|PATCH</td><td>  /api/workouts/{workouts}                               </td></tr> 
<tr><td>DELETE   </td><td>  /api/workouts/{workouts}                               </td></tr> 
<tr><td>GET      </td><td>  /api/groups                                            </td></tr> 
<tr><td>POST     </td><td>  /api/groups                                            </td></tr> 
<tr><td>GET      </td><td>  /api/groups/{groups}                                   </td></tr> 
<tr><td>PUT|PATCH</td><td>  /api/groups/{groups}                                   </td></tr> 
<tr><td>DELETE   </td><td>  /api/groups/{groups}                                   </td></tr> 
</table>

/api/sets/workouts/{workout_id}/exercises/{exercise_id}

 Display a listing of the sets that are associated with a workout 
 and an exercise, and that were created between a start date
 and an end date.  

 If no date query parameters are supplied, then it defaults to getting
 all sets created today.    

 If Carbon::create fails, an internal server error is returned, along
 with a helpful error message.  Catching illegalArgumentExceptions
 was not successful, so try-catch blocks were removed.

If startYear, startMonth, and startDay are provided
and startHour, startMinute, startSecond, and tz are not provided, 
then startHour, startMinute, startSecond, and tz default to the current 
hour, minute, second, or timezone, respectively. The same applies to 
end dates and times.

In other words, startHour, startMinute, and startSecond are optional.
In other words, endHour, endMinute, and endSecond are optional.

Here is an example of getting all sets after 2016-05-24 23:30:0
http://[rooturl]/api/workouts/1/exercises/1/sets?startYear=2016&startMonth=05&startDay=24&startHour=23&startMinute=30&startSecond=0

@stop